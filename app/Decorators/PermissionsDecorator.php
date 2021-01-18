<?php

namespace App\Decorators;

use App\Interfaces\PermissionInterface;
use App\Repositories\PermissionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PermissionsDecorator implements PermissionInterface
{
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return Cache::tags('permissions')->rememberForever('all', function () {
            return $this->permissionRepository->all();
        });
    }
}
