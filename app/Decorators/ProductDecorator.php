<?php

namespace App\Decorators;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Traits\QueryToString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductDecorator implements ProductInterface
{
    use QueryToString;

    private $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Query on resource list
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request)
    {
        $query = $this->convertQueryToString($request);

        return Cache::tags('products')->rememberForever($query, function () use ($request) {
            return $this->products
                ->name($request->get('name'))
                ->reference($request->get('reference'))
                ->paginate();
        });
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return Cache::tags('products')->rememberForever('all', function () {
            return $this->products::paginate();
        });
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return Cache::tags('products')->rememberForever($id, function () use ($id) {
            return $this->products::findOrFail($id);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->products::create($request->all());

        return Cache::tags('products')->flush();
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return Cache::tags('products')->flush();
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        $this->products::destroy($model->id);

        return Cache::tags('products')->flush();
    }
}
