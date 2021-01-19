<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use App\Http\Requests\Permissions\UpdateRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    private $users;

    public function __construct(UserInterface $users)
    {
        $this->users = $users;
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize(Permissions::EDIT_PERMISSIONS);

        $this->users->updatePermissions($request, $user);

        return redirect(route('users.show', $user->id))
            ->with('success', trans('resources.updated'));
    }
}
