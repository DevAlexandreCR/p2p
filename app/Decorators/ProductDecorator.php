<?php

namespace App\Decorators;

use App\Actions\ImageStorageAction;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Traits\QueryToString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\File;

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
                ->name($request->input('name'))
                ->reference($request->input('reference'))
                ->paginate(12);
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
        $request->merge([
            'slug' => Str::slug($request->input('name'))
        ]);
        $product = $this->products::create($request->all());

        ImageStorageAction::execute($request->file('image'), $product);

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

        ImageStorageAction::execute($request->file('image'), $model);

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
