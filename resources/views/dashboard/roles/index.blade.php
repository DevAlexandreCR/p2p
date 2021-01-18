@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container py-4">
            <button type="button" data-toggle="modal" data-target="#addRole"class="btn btn-dark">{{trans('Add role')}}</button>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header"><h3>{{trans('Remove roles')}}</h3></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            @foreach($roles as $role)
                                <tr class="align-middle">
                                    <th>{{trans($role->name)}}</th>
                                    <td>
                                        <form class="flex-column" action="{{route('roles.destroy', $role->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    @if($role->name === \App\Constants\Roles::SUPER_ADMIN) disabled="disabled"@endif><ion-icon name="trash"></ion-icon></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h3>{{trans('Roles')}}</h3></div>
                    <div class="card-body">
                        <div class="nav nav-pills card p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach($roles as $key => $role)
                                <a class="nav-link btn-block @if ($key === 0) 'active' @endif" id="v-pills-{{$role->name}}" data-toggle="pill"
                                   href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="true">
                                    {{trans('Show permissions') }} {{trans($role->name)}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header"><h3>{{trans('Permissions')}}</h3></div>
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach($roles as $key => $role)
                                <div class="tab-pane fade  @if ($key === 0) 'show active' @endif" id="{{$role->name}}" role="tabpanel" aria-labelledby="#v-pills-{{$role->name}}">
                                    @if($role->name === \App\Constants\Roles::SUPER_ADMIN)
                                        <div class="jumbotron">
                                            <h4>{{\App\Constants\Roles::SUPER_ADMIN}}</h4>
                                            <p class="lead">{{trans('User has super admin permissions')}}</p>
                                        </div>
                                    @else
                                        <form action="{{route('roles.update', $role->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <ul class="list-group overflow-auto" style="max-height: 50vh">
                                                @foreach ($permissions as $permission)
                                                    <li class="list-group-item-action text-right">
                                                        <label for="perm{{$permission->id}}">{{$permission->name}}</label>
                                                        <input class="custom-checkbox ml-4 mr-2" type="checkbox"
                                                               id="perm{{$permission->id}}" name="permissions[]" value="{{$permission->id}}"
                                                               @if($role->hasDirectPermission($permission->name)) checked @endif>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button type="submit" class="btn btn-block btn-success">{{trans('roles.update')}}</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="addRole" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{trans('roles.add')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('roles.store')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{trans('fields.name')}}</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{trans('actions.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
