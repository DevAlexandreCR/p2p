<?php

namespace App\Decorators;

use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserDecorator implements UserInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
        // TODO: Implement find() method.
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
        // TODO: Implement update() method.
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        // TODO: Implement destroy() method.
    }
}
