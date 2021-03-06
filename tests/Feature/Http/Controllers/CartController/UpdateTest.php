<?php

namespace Tests\Feature\Http\Controllers\CartController;

use App\Models\Product;
use App\Models\User;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class UpdateTest extends BaseControllerTest
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

        $product->carts()->attach($this->user->cart->id, [
            'quantity' => 2
        ]);

        $response = $this->actingAs($this->user)->put(route('cart.update', $this->user->id), [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);
    }

    /**
     * Test return errors when data is nor valid
     * @return void
     */
    public function testReturnWithErrorValidationWhenDataIsNotValid(): void
    {
        $product = Product::factory()->create([
            'stock' => 5
        ]);

        $product->carts()->attach($this->user->cart->id, [
            'quantity' => 2
        ]);

        $response = $this->actingAs($this->user)->put(route('cart.update', $this->user->id), [
            'product_id' => 0,
            'quantity' => '6'
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'product_id',
                'quantity'
            ]);

        $this->assertDatabaseMissing('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => 1111,
            'quantity' => '5'
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
        $response = $this->actingAs($this->user)->put(route('cart.update', $anotherUser->id));

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
        $response = $this->put(route('cart.update', $this->user->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
