<?php


namespace Tests\Feature\Http\Controllers\HomeController;

use App\Models\Product;
use Tests\TestCase;

class IndexTest extends TestCase
{

    /**
     * Test an user can view home
     *
     * @return void
     */
    public function testAnUserCanViewHome()
    {
        $response = $this->get(route('home'));

        $response
            ->assertStatus(200)
            ->assertViewIs('home.home')
            ->assertViewHas('products');
    }

    /**
     * Test an user can view a product detail
     *
     * @return void
     */
    public function testAnUserCanViewAProductDetail()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('home.product', $product->slug));

        $response
            ->assertStatus(200)
            ->assertViewIs('home.show')
            ->assertViewHas('product', $product);
    }
}