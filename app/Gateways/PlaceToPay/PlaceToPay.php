<?php


namespace App\Gateways\PlaceToPay;


use App\Gateways\GatewayInterface;
use App\Models\Order;
use App\Models\Payer;
use App\Models\Payment;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class PlaceToPay implements GatewayInterface
{
    use Authentication;

    private string $endPoint = 'api/session/';

    private string $reverseEndPoint = 'api/reverse/';

    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('gateways.placeToPay.baseUrl');
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     * @throws Exception
     */
    public function create(Order $order): RedirectResponse
    {
        try {
            $response = Http::asJson()->post(
                $this->baseUrl . $this->endPoint,
                $this->data($order)
            )->object();

            return $this->createPayment($response, $order);

        } catch (ClientException | ServerException $e) {

            Payment::create([
                'order_id' => $order->id,
                'status'   => Statuses::STATUS_FAILED
            ]);

            $order->update([
                'status'   => Statuses::STATUS_FAILED
            ]);

            return redirect()->to(route('users.orders.show', [auth()->id(), $order->id]))
                ->with('message', $e->getMessage());

        }
    }

    /**
     * @param Payment $payment
     * @return string
     * @throws Exception
     */
    public function getInformation(Payment $payment): string
    {
        $url = $this->baseUrl . $this->endPoint . $payment->request_id;
        try {
            $response = Http::post(
                $url,
                [
                    'auth' => $this->getAuth(),
                ]
            )->object();

            $this->updatePayment($response, $payment);
            return $response->status->status;
        }catch (ClientException | ServerException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     * @throws Exception
     */
    public function retry(Payment $payment): RedirectResponse
    {

    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     * @throws Exception
     */
    public function reverse(Payment $payment): RedirectResponse
    {
        try {
            $response = Http::post(
                $this->baseUrl . $this->reverseEndPoint,
                [
                    'auth' => $this->getAuth(),
                    'internalReference' => $payment->reference,

                ]
            )->object();


            return $this->createPayment($response, $payment->order);
        }catch (ClientException | ServerException $e) {
            Payment::update([
                'status'   => Statuses::STATUS_FAILED
            ]);

            $payment->order()->update([
                'status' => Statuses::STATUS_FAILED
            ]);
            return redirect()->to(route('user.order.show', [auth()->id(), $payment->order->id]))
                ->with('message', $e->getMessage());
        }
    }

    /**
     * build data to send to request
     * @param Order $order
     * @return array
     * @throws Exception
     */
    private function data(Order $order): array
    {
        $auth = $this->getAuth();
        $expiration = date('c', strtotime('+2 days'));

        return [
            'auth' => $auth,
            'payment' => [
                'reference' => $order->id,
                'description' => 'user ' . $order->user->email . ' pay order ' . $order->id,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->amount,
                ],
            ],
            'expiration' => $expiration,
            'returnUrl' => route('users.orders.show', [auth()->id(), $order->id]),
            'ipAddress' => request()->getClientIp(),
            'userAgent' => request()->header('User-Agent'),
        ];
    }

    /**
     * Handle response status
     *
     * @param $response
     * @param Payment $payment
     */
    private function updatePayment($response, Payment $payment): void
    {
        $status = $response->status->status;

        $payment::update([
            'status' => $status
        ]);

        $payment->order()->update([
            'status' => $status
        ]);

        switch ($status) {
            case Statuses::STATUS_APPROVED:
                $payer = $response->request->payer;
                $dbPayer = Payer::create(
                    [
                        'document'      => $payer->document,
                        'document_type' => $payer->documentType,
                        'email'         => $payer->email,
                        'name'          => $payer->name,
                        'last_name'     => $payer->surname,
                        'phone'         => $payer->mobile,
                    ]
                );
                $payment::update([
                    'payer_id'  => $dbPayer->id,
                    'reference' => $response->payment[0]->internalReference,
                    'method'    => $response->payment[0]->paymentMethod,
                    'last_digit'=> $response->payment[0]->processorFields[0]->value
                ]);
                break;
            case Statuses::STATUS_REFUNDED:
                $payment->order->products()->dettach();
                break;
        }
    }

    private function createPayment($response, Order $order): RedirectResponse
    {
        $requestId = $response->requestId;
        $processUrl = $response->processUrl;

        Payment::create([
            'order_id'   => $order->id,
            'requestId'  => $requestId,
            'processUrl' => $processUrl,
            'amount'     => $order->amount
        ]);

        return redirect()->away($processUrl)->send();
    }
}