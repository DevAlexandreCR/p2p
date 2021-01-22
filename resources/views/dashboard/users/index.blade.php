@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-primary mb-2" href="{{route('users.create')}}">
                    <i class="bi bi-person-plus-fill me-2"></i>{{trans('users.add_employee')}}
                </a>
            </div>
            <div class="col-md-5">

            </div>
            <div class="col-md-4">
                <form class="d-flex" action="{{route('users.index')}}" method="get">
                    <input class="form-control me-2" type="search" name="search" value="{{request()->get('search')}}"
                           placeholder="{{trans('actions.search')}}" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">{{trans('actions.search')}}</button>
                </form>
            </div>
        </div>
        <div class="card px-2 my-2">
            <div class="card-body">
                <table class="table table-sm table-hover table-responsive-lg">
                    <thead>
                    <tr>
                        <th>{{trans('fields.id')}}</th>
                        <th>{{trans('users.name')}}</th>
                        <th>{{trans('users.email')}}</th>
                        <th>{{trans('fields.status')}}</th>
                        <th style="text-align: center">{{trans('fields.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $key => $user)
                        <tr class="@if(!$user->enabled) text-muted @endif">
                            <td scope="row">{{ $key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->enabled)
                                <td>
                                    <span class="badge bg-success"><i class="bi bi-check me-2"></i>{{ trans('actions.enabled') }}</span>
                                </td>
                            @else
                                <td class="text-muted">
                                    <span class="badge bg-danger"><i class="bi bi-x me-2"></i> {{ trans('actions.disabled') }}</span>
                                </td>
                            @endif
                            <td class="text-center" style="border-left: groove">
                                <div class="d-inline">
                                    <a type="button" class="btn btn-link pt-2 mr-4 btn-sm"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="{{trans('actions.view')}}"
                                       href="{{route('users.show', $user->id)}}">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <form class="d-inline" action="{{route('users.update', $user->id)}}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="enabled" value="@if($user->enabled) {{0}}@else {{1}} @endif">
                                        <button type="submit" class="btn btn-link btn-sm text-black-50 p-0"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="@if($user->enabled) {{trans('actions.disable')}} @else{{trans('actions.enable')}} @endif">
                                            @if($user->enabled)
                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                            @else
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @endif

                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row row-cols-2 text-end pe-5">
                <div class="col-sm-6">{{$users->onEachSide(5)->links()}}</div>
                <div class="col-sm-6">
                    <div class="card-title">
                        {{trans_choice('users.user', $users->total(), ['user_count'=> $users->total()])}}
                        <a class="btn btn-link" href="{{route('users.index')}}">{{trans('actions.view_all')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection