<?php


namespace App\Decorators;


use App\Interfaces\RoleInterface;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleDecorator implements RoleInterface
{

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Cache::tags('roles')->rememberForever('all', function (){
            return $this->roleRepository->all();
        });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return Cache::tags('roles')->rememberForever($id, function () use ($id){
            return $this->roleRepository->find($id);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->roleRepository->store($request);

        return Cache::tags('roles')->flush();
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        $this->roleRepository->update($request, $model);

        return Cache::tags('roles')->flush();
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        $this->roleRepository->destroy($model);

        return Cache::tags('roles')->flush();
    }
}
