<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\IndexRequest;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{

    private $users;

    public function __construct(UserInterface $users)
    {
        $this->authorizeResource(User::class);
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        return view('dashboard.users.index', [
            'users' => $this->users->query($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->users->store($request);

        return redirect(route('users.create'))
            ->with('success', trans('resources.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param RoleInterface $roles
     * @param PermissionInterface $permissions
     * @return View
     */
    public function show(User $user, RoleInterface $roles, PermissionInterface $permissions): View
    {
        return view('dashboard.users.show', [
            'user' => $user,
            'roles' => $roles->all(),
            'permissions' => $permissions->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $this->users->update($request, $user);

        return back()->with('success', trans('resources.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->users->destroy($user);

        return redirect(route('users.index'))
            ->with('success', trans('resources.removed'));
    }
}
