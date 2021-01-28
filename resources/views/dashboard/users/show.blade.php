@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><h4>{{trans('users.data')}}</h4></div>
                    <div class="card-body">
                        <form action="{{route('users.update', $user->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <table class="table table-responsive-sm table-borderless">
                                <thead>
                                <tr>
                                    <th class="align-middle">{{trans('users.name')}}:</th>
                                    <td>
                                        <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">{{trans('users.email')}}:</th>
                                    <td>
                                        <input class="form-control" type="email" name="email" value="{{$user->email}}" id="email" autocomplete="nope">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="align-middle">{{trans('fields.status')}}:</th>
                                    <td>
                                        <select class="form-control" type="text" name="enabled" id="is_active">
                                            <option value="{{0}}" @if (!$user->enabled) selected @endif>{{trans('actions.disabled')}}</option>
                                            <option value="{{1}}" @if ($user->enabled) selected @endif>{{trans('actions.enabled')}}</option>
                                        </select>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <button type="submit" class="btn btn-primary w-100 my-3">{{trans('users.update')}}</button>
                        </form>
                        <hr>
                        <form action="{{route('permissions.update', $user->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <table class="table table-responsive-sm table-borderless">
                                <thead>
                                <tr>
                                    <th class="align-top">{{ trans_choice('roles.role', 2, ['role_count' => '']) }}:</th>
                                    <td>
                                        <ul>
                                            @foreach($roles as $key => $role)
                                                <li class="text-right">
                                                    <label class="mr-2" for="perm{{$key}}">{{__($role->name)}}</label>
                                                    <input class="custom-checkbox text-right" type="checkbox" id="perm{{$key}}" name="roles[]" value="{{$role->id}}"
                                                           @if($user->hasRole($role->name)) checked @endif>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <button type="submit" class="btn btn-primary w-100 my-3">{{trans('roles.update')}}</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><h4>{{trans_choice('roles.permission', 2, ['permission_count' => ''])}}</h4></div>
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            @if($user->hasRole(\App\Constants\Roles::SUPER_ADMIN))
                                <div class="container">
                                    <h1 >{{trans('roles.admin')}}</h1>
                                    <p class="lead">{{trans('roles.messages.all')}}</p>
                                </div>
                            @else
                                <form action="{{route('permissions.update', $user->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <ul class="list-group overflow-auto" style="max-height: 50vh">
                                        @foreach ($permissions as $id => $permission)
                                            <li class="list-group-item-action text-end">
                                                @foreach($user->roles as $role)
                                                    @if($role->hasPermissionTo($permission->name)) {{trans('roles.messages.permission_form_rol')}}:  @endif
                                                @endforeach
                                                <label class="mr-5" for="perm{{$permission->id}}">{{trans($permission->name)}}</label>
                                                <input class="nv-check-box" type="checkbox" id="perm{{$permission->id}}" name="permissions[]" value="{{$permission->id}}"
                                                       @if($user->hasPermissionTo($permission->name)) checked @endif
                                                       @foreach($user->roles as $role)
                                                       @if($role->hasPermissionTo($permission->name)) disabled @endif
                                                        @endforeach
                                                >
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <button type="submit" class="btn w-100 btn-primary">{{trans('roles.update')}}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection