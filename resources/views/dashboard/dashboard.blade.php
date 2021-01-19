@extends('layouts.app')

@section('content')
    <a class="btn btn-light ml-4" href="{{route('roles.index')}}">{{trans('Roles')}}</a>
    <a class="btn btn-light ml-4" href="{{route('users.index')}}">{{trans('Users')}}</a>
@endsection
