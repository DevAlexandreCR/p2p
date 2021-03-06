<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    private RoleInterface $roles;
    private PermissionInterface $permissions;

    public function __construct(RoleInterface $roles, PermissionInterface $permissions)
    {
        $this->authorizeResource(Role::class);
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.roles.index', [
            'roles' => $this->roles->all(),
            'permissions' => $this->permissions->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->roles->store($request);

        return redirect(route('roles.index'))
            ->with('success', trans('resources.created'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Role $role): RedirectResponse
    {
        $this->roles->update($request, $role);

        return redirect(route('roles.index'))
            ->with('success', trans('resources.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->roles->destroy($role);

        return redirect(route('roles.index'))
            ->with('success', trans('resources.removed'));
    }
}
