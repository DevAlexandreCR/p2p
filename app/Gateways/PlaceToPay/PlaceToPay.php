<?php

namespace App\Gateways\PlaceToPay;

use App\Constants\PaymentGateway;
use App\Gateways\GatewayContext;
use App\Gateways\GatewayInterface;
use App\Gateways\MakeRequest;
use App\Gateways\PlaceToPay\PaymentStatuses\PaymentApproved;
use App\Gateways\PlaceToPay\PaymentStatuses\PaymentDefault;
use App\Gateways\PlaceToPay\PaymentStatuses\PaymentOk;
use App\Gateways\PlaceToPay\PaymentStatuses\PaymentRefunded;
use App\Gateways\Statuses;
use App\Models\Order;
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

    /**
     * @var array|string[]
     */
    protected array $statuses = [
      Statuses::STATUS_APPROVED => PaymentApproved::class,
      Statuses::STATUS_REFUNDED => PaymentRefunded::class,
      Statuses::STATUS_OK       => PaymentOk::class,
      Statuses::STATUS_REJECTED => PaymentDefault::class,
      Statuses::STATUS_FAILED   => PaymentDefault::class
    ];

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
    public function updatePayment($response, Payment $payment): void
    {
        $response->status->status = $this->changeStatus($response);

        $updateStatus = new $this->statuses[$response->status->status]();

        (new GatewayContext($updateStatus))->updatePayment($payment, $response);
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
