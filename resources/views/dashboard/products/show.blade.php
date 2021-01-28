@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="card m-auto col-lg-6">
            <div class="card-header">{{$product->name}}</div>
            <form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <img src="{{ asset('images/' . $product->image)}} " class="img-fluid rounded img-product-detail" id="image-product" alt="image" height="h-100">
                        <input-image-component :name="'image'" :img-id="'image-product'"></input-image-component>
                    </div>
                    <div class="row">
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="product-name" name="name"
                                           placeholder="new product" value="{{$product->name}}">
                                    <label for="product-name">{{trans('products.name')}}</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="product-reference" name="reference"
                                           placeholder="100000" value="{{ $product->reference }}">
                                    <label for="product-reference">{{trans('products.reference')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea style="height: 100px" type="text" class="form-control text-start" id="product-description" name="description"
                            placeholder="leave me a description">
                                {{ $product->description }}
                            </textarea>
                            <label for="product-description" class="form-label">{{trans('products.description')}}</label>
                        </div>
                        <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="product-stock" name="stock"
                                               placeholder="10" value="{{$product->stock}}">
                                        <label for="product-stock">{{trans('products.quantity')}}</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="product-price" name="price"
                                               placeholder="50000" value="{{ $product->price }}">
                                        <label for="product-price">{{trans('products.price')}}</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success w-100">{{trans('actions.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection