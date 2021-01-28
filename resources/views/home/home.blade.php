@extends('layouts.app')

@section('content')

    @include('home.banner')

    @include('home.product-grid', [
        'products' => $products
    ])

@endsection
