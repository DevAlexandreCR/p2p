@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        @foreach($products as $product)
            {{$product}}
        @endforeach
    </div>
@endsection