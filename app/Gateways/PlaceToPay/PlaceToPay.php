<?php

namespace App\Gateways\PlaceToPay;

use App\Constants\Orders;
use App\Constants\PaymentGateway;
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

    private string $gateway = PaymentGateway::PLACE_TO_PAY;

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

            return $this->createPayment($response, $order, $this->gateway);
        } catch (ClientException | ServerException $e) {
            Payment::create([
                'order_id' => $order->id,
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
        } catch (ClientException | ServerException $e) {
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
        try {
            $response = Http::asJson()->post(
                $this->baseUrl . $this->endPoint,
                $this->data($payment->order)
            )->object();
            $this->updatePayment($response, $payment);
            return redirect()->away($response->processUrl)->send();
        } catch (ClientException | ServerException $e) {
            return redirect()->to(route('users.orders.show', [auth()->id(), $payment->order->id]))
                ->with('message', $e->getMessage());
        }
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

            $this->updatePayment($response, $payment);

            $message = $response->status->message;
        } catch (ClientException | ServerException $e) {
            $message = $e->getMessage();
        }
        return redirect()->to(route('users.orders.show', [auth()->id(), $payment->order->id]))
            ->with('message', $message);
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
        $status = $this->changeStatus($response);

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
                $payment->update([
                    'payer_id'   => $dbPayer->id,
                    'reference'  => $response->payment[0]->internalReference,
                    'method'     => $response->payment[0]->paymentMethod,
                    'last_digit' => $response->payment[0]->processorFields[0]->value,
                    'status'     => $status
                ]);
                $payment->order()->update([
                    'status' => Orders::STATUS_COMPLETED
                ]);
                break;
            case Statuses::STATUS_REFUNDED:
                $payment->order->products()->detach();
                $payment->update([
                    'status'      => Statuses::STATUS_REFUNDED
                ]);
                $payment->order()->update([
                    'status' => Orders::STATUS_CANCELED
                ]);
                break;
            case Statuses::STATUS_OK:
                $requestId = $response->requestId;
                $processUrl = $response->processUrl;
                $payment->update([
                    'request_id'  => $requestId,
                    'process_url' => $processUrl,
                    'status'      => Statuses::STATUS_PENDING
                ]);
                break;
            default:
                $payment->update([
                    'status' => $status
                ]);
                break;
        }
    }

    /**
     * @param $response
     * @param Order $order
     * @param string $gateway
     * @return RedirectResponse
     */
    private function createPayment($response, Order $order, string $gateway): RedirectResponse
    {
        $requestId = $response->requestId;
        $processUrl = $response->processUrl;

        Payment::create([
            'order_id'   => $order->id,
            'request_id'  => $requestId,
            'process_url' => $processUrl,
            'amount'     => $order->amount,
            'gateway'    => $gateway
        ]);

        return redirect()->away($processUrl)->send();
    }

    /**
     * @param $response
     * @return string
     */
    public function changeStatus($response): string
    {
        return $response->status->message === 'Se ha reversado el pago correctamente' ? Statuses::STATUS_REFUNDED :
            $response->status->status;
    }
}
