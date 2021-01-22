<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface extends BaseRepositoryInterface
{
    /**
     * Query on resource list
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request);
}
