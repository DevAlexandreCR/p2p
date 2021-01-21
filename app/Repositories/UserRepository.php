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
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request)
    {
        return $this->user::select('id', 'name', 'email', 'enabled')->paginate();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->user::select('id', 'name', 'email', 'enabled')->paginate();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->user::select('id', 'name', 'enabled', 'email')->whereId($id);
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
        $user->syncPermissions($request->get('permissions'));

        if (key_exists('roles', $request->all())) {
            $user->syncRoles($request->get('roles'));
        }
    }
}
