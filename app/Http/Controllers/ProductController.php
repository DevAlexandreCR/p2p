<?php

namespace App\Http\Controllers;

use App\Decorators\ProductDecorator;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{

    private $products;

    public function __construct(ProductDecorator $products)
    {
        $this->authorizeResource(Product::class);
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        return view('dashboard.products.index', [
            'products' => $this->products->query($request)->withPath(route('products.index'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->products->store($request);

        return redirect(route('products.create'))
            ->with('success', trans('resources.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('dashboard.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $this->products->update($request, $product);

        return redirect(route('products.show', $product->id))
            ->with('success', trans('resources.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->products->destroy($product);

        return redirect(route('products.index'))
            ->with('success', trans('resources.removed'));
    }
}
