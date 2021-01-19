<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserRepository implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->user::all('name', 'email', 'enabled');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->user::find($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->user::create($request->all());
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        return $model->update($request->all());
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        return $this->user::destroy($model->id);
    }

    /**
     * Update user permissions and roles
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function updatePermissions(Request $request, User $user)
    {
        if (key_exists('permissions', $request->all())) {
            $user->syncPermissions($request->get('permissions'));
        }

        if (key_exists('roles', $request->all())) {
            $user->syncRoles($request->get('roles'));
        }
    }
}
