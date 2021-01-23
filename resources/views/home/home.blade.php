@extends('layouts.app')

@section('content')

    @include('home.product-grid', [
        'products' => $products
    ])

@endsection
