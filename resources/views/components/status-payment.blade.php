<div>
    @switch($payment->status)
        @case(\App\Gateways\PlaceToPay\Statuses::STATUS_FAILED)
            <p><small>{{session('message')}}</small></p>
            <p><small>{{trans('payment.messages.failed')}}</small></p>
            <form action="{{route('users.orders.retry', [auth()->id(), $payment->order->id])}}" method="post">
                @csrf
                <button type="submit" class="btn w-100 btn-sm btn-success">{{trans('payment.retry')}}</button>
            </form>
        @break
        @case(\App\Gateways\PlaceToPay\Statuses::STATUS_PENDING)
            <p><small>{{trans('payment.messages.pending')}}</small></p>
            <form action="{{route('users.orders.update', [auth()->id(), $payment->order->id])}}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn w-100 btn-sm btn-dark">{{trans('payment.verify')}}</button>
            </form>
            <p><small>{{trans('payment.messages.retry_again')}}</small></p>
                <a class="btn btn-success btn-sm w-100" href="{{$payment->process_url}}">{{trans('payment.retry')}}</a>
        @break
        @case(\App\Gateways\PlaceToPay\Statuses::STATUS_APPROVED)
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
        @case(\App\Gateways\PlaceToPay\Statuses::STATUS_REJECTED)
            <p><small>{{trans('payment.messages.rejected')}}</small></p>
            <form action="{{route('users.orders.retry', [auth()->id(), $payment->order->id])}}" method="post">
                @csrf
                <button type="submit" class="btn w-100 btn-sm btn-success">{{trans('payment.retry')}}</button>
            </form>
        @break
        @case(\App\Gateways\PlaceToPay\Statuses::STATUS_REFUNDED)
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
</div>
