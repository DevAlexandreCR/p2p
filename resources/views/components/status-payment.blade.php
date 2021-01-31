<div>
    @switch($payment->status)
        @case(\App\Gateways\Statuses::STATUS_FAILED)
            <p><small>{{session('message')}}</small></p>
            <p><small>{{trans('payment.messages.failed')}}</small></p>
        <button type="button" class="btn btn-success btn-sm me-2 w-100" data-bs-toggle="modal"
                data-bs-target="#retry-modal">{{trans('payment.retry')}}</button>
        @break
        @case(\App\Gateways\Statuses::STATUS_PENDING)
            <p><small>{{trans('payment.messages.pending')}}</small></p>
            <form action="{{route('users.orders.update', [auth()->id(), $payment->order->id])}}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn w-100 btn-sm btn-dark">{{trans('payment.verify')}}</button>
            </form>
            <p><small>{{trans('payment.messages.retry_again')}}</small></p>
                <a class="btn btn-success btn-sm w-100" href="{{$payment->process_url}}">{{trans('payment.retry')}}</a>
        @break
        @case(\App\Gateways\Statuses::STATUS_APPROVED)
            <p><small>{{trans('payment.messages.preparing')}}</small></p>
                <h3>{{trans('payer.data')}}</h3>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.full_name')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->payer->name}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payer.document')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->payer->document_type}} : {{$payment->payer->document}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.email')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->payer->email}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.phone')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->payer->phone}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.method')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->method}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('products.reference')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->reference}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.last_digit')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->last_digit}}
                    </div>
                </div>
                <hr>
            <form action="{{route('users.orders.reverse', [auth()->id(), $payment->order->id])}}" method="post">
                @csrf
                <button type="submit" class="btn w-100 btn-sm btn-danger">{{trans('payment.cancel')}}</button>
            </form>
        @break
        @case(\App\Gateways\Statuses::STATUS_REJECTED)
            <p><small>{{trans('payment.messages.rejected')}}</small></p>
        <button type="button" class="btn btn-success btn-sm me-2 w-100" data-bs-toggle="modal"
                data-bs-target="#retry-modal">{{trans('payment.retry')}}</button>
        @break
        @case(\App\Gateways\Statuses::STATUS_REFUNDED)
            <p><small>{{trans('orders.statuses.canceled')}}</small></p>
            @if($payment->payer)
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.messages.back')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$payment->amount}}
                    </div>
                </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('payment.method')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$payment->method}}
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('products.reference')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$payment->reference}}
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('payment.last_digit')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$payment->last_digit}}
                </div>
            </div>
            @endif
        @break
    @endswitch
        <div class="modal fade" tabindex="-1" id="retry-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('payment.select') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <payment-gateways-component
                                :input-id="'payment_gateway_retry'"
                                :form-id="'form-payment_retry'"></payment-gateways-component>
                    </div>
                    <form class="btn-block" id="form-payment_retry" action="{{ route('users.orders.retry', [auth()->id(), $payment->order->id]) }}"  method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{auth()->id()}}">
                        <input type="hidden" name="gateway_name" id="payment_gateway_retry">
                    </form>
                </div>
            </div>
        </div>
</div>
