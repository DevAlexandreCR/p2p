<div class="container">
@if(Session::has('success'))
	<toast-component type="success" message="{{ session('success') }}"></toast-component>
@endif

@if(Session::has('message'))
	<toast-component type="success" message="{{ session('message') }}"></toast-component>
@endif

@if ( session('errors') && $errors->any() )

@foreach ($errors->all() as $error)
	<toast-component type="error" message="{{ $error }}"></toast-component>
@endforeach

@endif

@if(Session::has('error'))
	<toast-component type="error" message="{{ session('error') }}"></toast-component>
@endif
</div>