@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-primary mb-2" href="{{route('products.create')}}">
                    <i class="bi bi-tags-fill me-2"></i>{{trans('actions.add')}}
                </a>
            </div>
            <div class="col-md-5">

            </div>
            <div class="col-md-4">
                <form class="d-flex" action="{{route('products.index')}}" method="get">
                    <input class="form-control me-2" type="search" name="name" value="{{request()->input('name')}}"
                           placeholder="{{trans('products.name')}}" aria-label="Search">
                    <input class="form-control me-2" type="search" name="reference" value="{{request()->input('reference')}}"
                           placeholder="{{trans('products.reference')}}" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">{{trans('actions.search')}}</button>
                </form>
            </div>
        </div>
        <div class="card px-2 my-2">
            <div class="card-body table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>{{trans('fields.id')}}</th>
                        <th>{{trans('products.name')}}</th>
                        <th>{{trans('products.reference')}}</th>
                        <th>{{trans('products.description')}}</th>
                        <th>{{trans('products.price')}}</th>
                        <th>{{trans('fields.quantity')}}</th>
                        <th style="text-align: center">{{trans('fields.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $key => $product)
                        <tr class="@if($product->stock === 0) text-muted @endif">
                            <td scope="row">{{ $key }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->reference }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td class="text-center" style="border-left: groove">
                                <div class="d-inline-flex text-center">
                                    <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#product-modal" data-bs-product="{{ $product }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <a type="button" class="btn btn-light mr-4 btn-sm"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="{{trans('actions.view')}}"
                                       href="{{route('products.show', $product->id)}}">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <switch-component
                                            :form-id="'formEnableProduct'"
                                            :input-id="'enableProduct'"
                                            :action="'{{route('products.update', $product->id)}}'"
                                            :status="@if($product->enabled) true @else false @endif">
                                    </switch-component>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <form class="d-inline"  method="POST" id="formEnableProduct">
                    @csrf @method('PUT')
                    <input type="hidden" name="enabled" id="enableProduct">
                </form>
            </div>
            <div class="row row-cols-2 text-end pe-5">
                <div class="col-sm-6">{{$products->onEachSide(3)->withQueryString()->links()}}</div>
                <div class="col-sm-6">
                    <div class="card-title">
                        {{trans_choice('products.product', $products->total(), ['product_count'=> $products->total()])}}
                        <a class="link" href="{{route('products.index')}}">{{trans('actions.view_all')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <product-modal-component></product-modal-component>
    </div>
@endsection