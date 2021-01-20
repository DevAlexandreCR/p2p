<div class="bg-light" id="sidebar-wrapper">
    <div class="sidebar-heading">{{config('app.name')}}</div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action bg-light" href="{{route('roles.index')}}">{{trans('Roles')}}</a>
        <a class="list-group-item list-group-item-action bg-light" href="{{route('users.index')}}">{{trans('Users')}}</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
    </div>
</div>
