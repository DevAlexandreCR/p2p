@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal-header"><h3>{{trans_choice('orders.orders', 2, ['orders_count' => ''])}}</h3></div>
        @if($orders->count() === 0)
            <div class="container w-50">
                <div class="alert alert-warning w-50 mx-auto mt-5 text-center" role="alert">
                    <strong>{{ trans('orders.empty') }}</strong>
                    <a class="link" href="{{ route('home') }}">{{ trans('users.go_shopping') }}</a>
                </div>
            </div>
        @else
            <div class="container justify-content-center">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>{{trans_choice('orders.orders', 1, ['orders_count' => '']) .
                            trans('fields.created_at')}}</th>
                        <th>{{trans('fields.status')}}</th>
                        <th>{{trans('orders.amount')}}</th>
                        <th class="text-center">{{trans('orders.details')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                $ {{number_format($order->amount)}}
                            </td>
                            <td class="text-center">
                                <div class="btn btn-group">
                                    <a href="{{route('users.orders.show', [auth()->id(), $order->id])}}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection