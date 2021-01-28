<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PermissionInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;
}
