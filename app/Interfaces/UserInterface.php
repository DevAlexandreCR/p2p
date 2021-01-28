<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface extends BaseRepositoryInterface
{

    /**
     * Update user permissions and roles
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    public function updatePermissions(Request $request, User $user);

    /**
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request);
}
