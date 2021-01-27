@extends('layouts.app')

@section('content')
    <div class="d-flex" id="wrapper">
        @include('dashboard.sidebar')
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand navbar-light mb-4">
                <button-toggle-component></button-toggle-component>
                <back-button-component></back-button-component>
            </nav>
            <div class="container-fluid">
                @yield('main')
            </div>
        </div>
    </div>
@endsection
