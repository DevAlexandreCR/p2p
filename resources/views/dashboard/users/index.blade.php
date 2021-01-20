@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="card px-2">
            <table class="table table-sm table-striped table-hover table-responsive-md">
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
                                <span class="badge bg-success text-white"> {{ trans('actions.enabled') }}</span>
                            </td>
                        @else
                            <td class="text-muted">
                                <span class="badge bg-danger text-white"> {{ trans('actions.disabled') }}</span>
                            </td>
                        @endif
                        <td class="text-center" style="border-left: groove">
                            <div class="d-inline"
                                 role="group">
                                <a type="button" class="btn btn-link pt-2 mr-4"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{trans('actions.view')}}"
                                   href="{{route('users.show', $user->id)}}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <form class="d-inline" action="{{route('users.update', $user->id)}}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="enabled" value="@if($user->enabled) {{0}}@else {{1}} @endif">
                                    <button type="submit" class="btn btn-link"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="@if($user->enabled) {{trans('actions.disable')}} @else{{trans('actions.enable')}} @endif">
                                        <i class="bi bi-shield-fill-check"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container text-center">
        {{ $users->links() }}<strong> {{trans_choice('users.user', $users->count(), ['user_count' => $users->total()])}} </strong>
    </div>
@endsection