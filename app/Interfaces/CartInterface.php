<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface CartInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function show(User $user): User;

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user): void;

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function delete(Request $request, User $user): void;

    /**
     * @param Request $request
     * @param User $user
     *
     * @return mixed
     */
    public function store(Request $request, User $user);
}
