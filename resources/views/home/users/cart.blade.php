@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3>{{trans('users.cart')}}</h3>
        @if($user->cart->products()->count() === 0)
            <empty-user-component></empty-user-component>
        @endif
        <div class="row py-4">
            <div class="col-lg-8 order-first font-mini">
                <div class="list-group" id="list-user">
                    @foreach($user->cart->products as $product)
                        <div class="list-group-item my-2">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <img class="img-fluid img-product-detail" src="{{asset('images/' . $product->image)}}">
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-bold">{{$product->name}}</p>
                                    <p class="small">{{$product->description}}</p>
                                    <div class="text-end">
                                        <form class="" action="{{route('cart.delete', [Auth::user()])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" class="btn  btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
                                    <div class="row">
                                        <label class="col-7 font-weight-bold mt-2">{{trans('products.price')}}: </label>
                                        <input class="form-control-plaintext col-5" value="{{$product->price * $product->pivot->quantity}}">
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <label class="col-6 font-weight-bold mt-2">{{trans('orders.subtotal')}}: </label>
                                        <input class="form-control-plaintext text-price col-6"
                                               value="{{ 000 }}">
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
                            <table class="table table-sm table-borderless">
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
                                        <td>{{ 000 }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="row font-weight-bold">
                                <div class="col-6 text-right">{{trans('orders.total')}}</div>
                                <div class="col-6 text-right">{{ 000 }}</div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="btn-group-vertical btn-block" role="group">
                                <form class="btn-block"  method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-success btn-block">{{trans('payment.pay')}}</button>
                                </form>
                                <a href="{{route('home')}}" type="button" class="btn btn-secondary">{{trans('payment.continue')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection