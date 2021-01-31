<?php

namespace App\Gateways\PlaceToPay;

use App\Constants\Orders;
use App\Constants\PaymentGateway;
use App\Gateways\GatewayInterface;
use App\Gateways\MakeRequest;
use App\Models\Order;
use App\Models\Payer;
use App\Models\Payment;
use Exception;
use Illuminate\Http\RedirectResponse;

class PlaceToPay implements GatewayInterface
{
    use Authentication;
    use MakeRequest;

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
        $response = $this->makeRequest('POST', $this->baseUrl . $this->endPoint, $this->data($order));

        if ($response->status->status === Statuses::STATUS_OK) {
            return $this->redirect($response, $order);
        }
        $order->payments()->first()->update([
            'status'   => Statuses::STATUS_FAILED
        ]);
        return redirect()->to(route('users.orders.show', [auth()->id(), $order->id]))
                ->with('message', $response->status->message);
    }

    /**
     * @param Payment $payment
     * @return string
     * @throws Exception
     */
    public function getInformation(Payment $payment): string
    {
        $url = $this->baseUrl . $this->endPoint . $payment->request_id;

        $response = $this->makeRequest('POST', $url, ['auth' => $this->getAuth()]);

        logger()->channel('daily')->debug(json_encode($response));

        $this->updatePayment($response, $payment);

        return $response->status->status;
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     * @throws Exception
     */
    public function retry(Payment $payment): RedirectResponse
    {
        $url = $this->baseUrl . $this->endPoint;

        $response = $this->makeRequest('POST', $url, $this->data($payment->order));

        logger()->channel('daily')->debug(json_encode($response));

        $this->updatePayment($response, $payment);

        if ($response->status->status === Statuses::STATUS_OK) {
            return redirect()->away($response->processUrl)->send();
        }

        return redirect()->to(route('users.orders.show', [auth()->id(), $payment->order->id]))
            ->with('message', $response->status->message);
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     * @throws Exception
     */
    public function reverse(Payment $payment): RedirectResponse
    {
        $url = $this->baseUrl . $this->reverseEndPoint;

        $response = $this->makeRequest('POST', $url, [
            'auth' => $this->getAuth(),
            'internalReference' => $payment->reference
        ]);

        $this->updatePayment($response, $payment);

        logger()->channel('daily')->debug(json_encode($response));

        return redirect()->to(route('users.orders.show', [auth()->id(), $payment->order->id]))
            ->with('message', $response->status->message);
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
                $payment->update([
                    'status' => Statuses::STATUS_REFUNDED
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
     * @return RedirectResponse
     */
    private function redirect($response, Order $order): RedirectResponse
    {
        $requestId = $response->requestId;
        $processUrl = $response->processUrl;

        $order->payments()->first()->update([
            'request_id'  => $requestId,
            'process_url' => $processUrl,
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
