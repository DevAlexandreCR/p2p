<?php

namespace App\Http\Controllers;

use App\Decorators\ProductDecorator;
use App\Http\Requests\Products\IndexRequest;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

    private $products;

    /**
     * Create a new controller instance.
     *
     * @param ProductDecorator $products
     */
    public function __construct(ProductDecorator $products)
    {
        $this->products = $products;
    }

    /**
     * Show the application home.
     *
     * @param IndexRequest $request
     * @return Renderable
     */
    public function index(IndexRequest $request): Renderable
    {
        return view('home.home', [
            'products' => $this->products->query($request)
        ]);
    }

    public function show(Product $product): Renderable
    {
        return view('home.show', [
            'product' => $product
        ]);
    }
}
