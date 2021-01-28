<div class="bg-light" id="sidebar-wrapper">
    <div class="sidebar-heading">{{trans('Menu')}}</div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action bg-light" href="{{route('roles.index')}}">{{trans('Roles')}}</a>
        <a class="list-group-item list-group-item-action bg-light" href="{{route('users.index')}}">{{trans('Users')}}</a>
        <a class="list-group-item list-group-item-action bg-light"
           href="{{route('products.index', ['admin' => true])}}">{{trans('fields.products')}}</a>
    </div>
</div>
