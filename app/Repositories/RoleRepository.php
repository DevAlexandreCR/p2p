<?php


namespace App\Repositories;


use App\Interfaces\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleInterface
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->role::all('id', 'name');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->role::findById($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->role::create([
            'name' => $request->get('name')
        ]);
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        return $model->update([
            'name' => $request->get('name')
        ]);
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        return $model->forceDelete();
    }
}
