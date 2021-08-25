@extends('layouts.app')

@section('content')
<div class="container"> 
    <payment-component :total="{{ $value }}"></payment-component>
</div>
@endsection