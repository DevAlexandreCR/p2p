@extends('dashboard.dashboard')

@section('main')
    <div class="container">
        <div class="container py-4">
            <button type="button" data-bs-toggle="modal" data-bs-target="#addRole" class="btn btn-primary">{{trans('Add role')}}</button>
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
                                            <button type="submit" class="btn btn-sm btn-danger text-white"
                                                    @if($role->name === \App\Constants\Roles::SUPER_ADMIN) disabled="disabled"@endif>
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
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
                                <a class="nav-link btn-block @if ($key === 0) 'active' @endif" id="v-pills-{{$role->name}}" data-bs-toggle="pill"
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
                                <div class="tab-pane fade  @if ($key === 0) 'show active' @endif" id="{{$role->name}}"
                                     role="tabpanel" aria-labelledby="#v-pills-{{$role->name}}">
                                    @if($role->name === \App\Constants\Roles::SUPER_ADMIN)
                                        <div class="card bg-body text-center py-4">
                                            <h4>{{\App\Constants\Roles::SUPER_ADMIN}}</h4>
                                            <p class="lead">{{trans('Role has super admin permissions')}}</p>
                                        </div>
                                    @else
                                        <form action="{{route('roles.update', $role->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <ul class="list-group overflow-auto" style="max-height: 50vh">
                                                @foreach ($permissions as $permission)
                                                    <li class="list-group-item-action text-end">
                                                        <label for="permission{{$role->name . $permission->id}}">{{$permission->name}}</label>
                                                        <input class="custom-checkbox ml-4 mr-2" type="checkbox"
                                                               id="permission{{$role->name . $permission->id}}" name="permissions[]" value="{{$permission->id}}"
                                                               @if($role->hasDirectPermission($permission->name)) checked @endif>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button type="submit" class="btn w-100 mt-2 btn-success">{{trans('roles.update')}}</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
