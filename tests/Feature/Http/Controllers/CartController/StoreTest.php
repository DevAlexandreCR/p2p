<?php

namespace Tests\Feature\Http\Controllers\CartController;

use App\Models\Product;
use App\Models\User;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create();
    }


    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $product = Product::factory()->create([
            'stock' => 5
        ]);

        $response = $this->actingAs($this->user)->post(route('cart.store', [
            'user' => $this->user->id,
            'quantity' => 30]), [
            'product_id' => $product->id,
            'quantity' => 2
            ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanAddExistingProductToCart()
    {
        $product = Product::factory()->create([
            'stock' => 5
        ]);

        $product->carts()->attach($this->user->cart->id, [
            'quantity' => 3
        ]);

        $response = $this->actingAs($this->user)->post(route('cart.store', $this->user->id), [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $product->id,
            'quantity' => 5
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $anotherUser = User::factory()->create();
        $response = $this->actingAs($this->user)->post(route('cart.store', $anotherUser->id));

        $response
            ->assertStatus(403)
            ->assertForbidden();
    }

    /**
     * Test user unauthenticated is redirected to Login.
     *
     * @return void
     */
    public function testAnUserUnauthenticatedIsRedirectedToLogin()
    {
        $response = $this->post(route('cart.store', $this->user->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
