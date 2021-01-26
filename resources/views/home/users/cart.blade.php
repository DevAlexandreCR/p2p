@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3>{{trans('users.cart')}}</h3>
        @if($user->cart->products()->count() === 0)
            <div class="alert alert-warning w-50 mx-auto mt-5 text-center" role="alert">
                <strong>{{ trans('users.empty_cart') }}</strong>
                <a class="link" href="{{ route('home') }}">{{ trans('users.go_shopping') }}</a>
            </div>
        @endif
        <div class="row py-4">
            <div class="col-lg-8 order-first font-mini">
                <div class="list-group" id="list-user">
                    @foreach($user->cart->products as $product)
                        <div class="list-group-item mt-2 border-1">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <img class="img-fluid img-product-detail" src="{{asset('images/' . $product->image)}}">
                                    <form class=" w-100" action="{{route('cart.delete', [$user])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        <div class="btn-group  w-100" role="group" aria-label="Basic example">
                                            <button type="submit" class="btn  btn-sm btn-danger  w-100">
                                                <i class="bi bi-trash-fill"></i>{{ trans('actions.remove') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-bold">{{$product->name}}</p>
                                    <p class="small">{{$product->description}}</p>

                                </div>
                                <div class="col-sm-4">
                                    <select-quantity-component
                                            :stock-available="{{ $product->stock }}"
                                            :product-id="{{ $product->id }}"
                                            :input-quantity="'product_quantity_cart_add'"
                                            :quantity-selected="{{ $product->pivot->quantity }}"
                                            :input-product="'product_id_cart_add'"
                                            :form-id="'update-cart'"
                                    ></select-quantity-component>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <span class="col-7 font-weight-bold mt-2">{{trans('products.price')}}: </span>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small class="small">$ {{number_format($product->price)}}</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-7">
                                            <span class="font-weight-bold mt-2">{{trans('orders.subtotal')}}: </span>
                                        </div>
                                        <div class="col-5">
                                            <p class="fw-bold">$ {{number_format($product->price * $product->pivot->quantity)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <form method="post" id="update-cart" action="{{route('cart.update', $user)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row pr-2">
                                <input name="product_id" type="number" hidden id="product_id_cart_add">
                                <input name="quantity" type="number" hidden id="product_quantity_cart_add">
                            </div>
                        </form>
                </div>
            </div>
            @if($user->cart->products->count() > 0)
                <div class="col-lg-4 order-sm-first my-2">
                    <div class="card text-center">
                        <div class="card-header">
                            {{trans('orders.summary')}}
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless text-muted">
                                <thead>
                                <tr class="text-right">
                                    <th scope="col">{{trans_choice('products.product', 1, ['product_count' => ''])}}</th>
                                    <th scope="col">{{trans('products.stock')}}</th>
                                    <th scope="col">{{trans('products.price')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->cart->products as $product)
                                    <tr class="text-right font-mini">
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->pivot->quantity}}</td>
                                        <td>$ {{ $product->totalPrice }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="row font-weight-bold">
                                <div class="col-6 text-right">{{trans('orders.total')}}</div>
                                <div class="col-6 text-right fw-bold">$ {{ $user->cart->totalCart }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="" role="group">
                                <form class="btn-block"  method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-success me-2 w-100">{{trans('payment.pay')}}</button>
                                </form>
                                <a href="{{route('home')}}" type="button" class="link-dark w-100 mt-2">{{trans('payment.continue')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection