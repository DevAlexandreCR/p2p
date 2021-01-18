<?php


namespace App\Repositories;


use App\Interfaces\PermissionInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->permission::all('id', 'name');
    }
}
