@extends('layouts.app')

@section('content')
    <div class="d-flex" id="wrapper">
        @include('dashboard.sidebar')
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button-toggle-component></button-toggle-component>
            </nav>
            <div class="container-fluid">
                @yield('main')
            </div>
        </div>
    </div>
@endsection
