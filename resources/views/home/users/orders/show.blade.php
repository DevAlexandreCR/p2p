@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card">
                    <div class="modal-header">
                        <h3>{{trans('orders.summary')}}</h3>
                        <small class="text-muted">{{$order->created_at}}</small>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-responsive-lg">
                            <thead>
                            <tr class="text-center">
                                <th scope="col"></th>
                                <th scope="col">{{trans('products.name')}}</th>
                                <th scope="col">{{trans('products.quantity')}}</th>
                                <th scope="col">{{trans('products.price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $product)
                                <tr class="text-center">
                                    <th><img class="img-table-mini" src="{{ asset('images/' . $product->image) }}"></th>
                                    <th class="align-middle">{{$product->name}}</th>
                                    <th class="align-middle">{{$product->pivot->quantity}}</th>
                                    <th class="align-middle">$ {{number_format($product->price * $product->pivot->quantity)}}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row text-end">
                            <div class="col-sm-10">
                                {{trans('orders.amount')}}:
                            </div>
                            <div class="col-sm-2 fw-bold text-end">
                                $ {{number_format($order->amount)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card my-2 my-lg-0">
                    <div class="card-header">
                        {{$order->status}}
                    </div>
                    <div class="card-body">
                        <x-status-payment :payment="$order->payments()->first()"/>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{route('home')}}" class="link my-2">{{trans('users.keep_buying')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection