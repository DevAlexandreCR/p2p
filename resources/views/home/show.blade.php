@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-5 justify-content-center">
            <div class="col-md-6 text-center">
                <img id="imgShowProduct" class="card-img-top"
                     src="{{asset('images/' . $product->image)}}" alt="{{ $product->image }}">
            </div>
            <div class="col-md-4">
                <div class="card my-md-0 my-2">
                    <div class="card-body">
                        <h2 class="card-title ps-2">{{$product->name}}</h2>
                        <form>
                            <div class="card-body">
                                <p>{{$product->description}}</p>
                                <hr>
                                <small class="text-small text-danger" id="quantitySmall"></small>
                                <div class="row g-3">
                                    <div class="col-auto">{{trans('products.quantity')}}: </div>
                                    <div class="col-auto">
                                        <select-stock-component :stock-available="{{$product->stock}}" :select-name="'quantity'"
                                        :input-print-id="'printPrice'" :price="{{ $product->price }}"></select-stock-component>
                                    </div>
                                    <div class="col-auto">
                                        <small class="small text-danger">{{ trans('products.stock_available') }} {{ $product->stock }}</small>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="fw-bold" id="printPrice">$ {{ number_format($product->price) }}</h5>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="{{$product->id}}" name="product_id">
                                @guest()
                                    <small class="text-danger">{{trans('users.messages.cart_no_login')}}</small>
                                @endguest
                                @if($product->stock === 0)
                                    <small class="text-muted text-danger">{{trans('users.messages.no_product')}}</small>
                                    <button type="button" disabled
                                            class="btn btn-secondary"><i class="bi bi-cart-plus-fill"></i></button>
                                @else
                                    <button type="submit" class="btn @auth() btn-primary @else btn-secondary @endauth"
                                            @guest() disabled @endguest><i class="bi bi-cart-plus-fill"></i></button>
                                @endif
                                <button class="btn btn-danger" type="button"
                                        onclick="history.back()">{{trans('actions.back')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection