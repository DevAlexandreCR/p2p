<?php


namespace Tests\Feature\Http\Controllers\HomeController;

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
            ->assertViewIs('home')
            ->assertViewHas('products');
    }
}