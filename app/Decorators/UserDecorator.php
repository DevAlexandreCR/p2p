<?php

namespace App\Decorators;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\QueryToString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserDecorator implements UserInterface
{
    use QueryToString;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request)
    {
        $query = $this->convertQueryToString($request);

        return Cache::tags('users')->rememberForever($query, function () use ($request) {
            return $this->userRepository->query($request);
        });
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Cache::tags('users')->rememberForever('all', function () {
            return $this->userRepository->all();
        });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return Cache::tags('users')->rememberForever('id', function () use ($id) {
            return $this->userRepository->find($id);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->userRepository->store($request);

        return Cache::tags('users')->flush();
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        $this->userRepository->update($request, $model);

        return Cache::tags('users')->flush();
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        $this->userRepository->destroy($model);

        return Cache::tags('users')->flush();
    }

    /**
     * Update user permissions and roles
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function updatePermissions(Request $request, User $user)
    {
        $this->userRepository->updatePermissions($request, $user);

        Cache::forget(config('permission.cache.key'));
    }
}
