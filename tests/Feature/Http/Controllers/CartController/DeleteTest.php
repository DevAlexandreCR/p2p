<?php

namespace Tests\Feature\Http\Controllers\CartController;

use App\Models\Product;
use App\Models\User;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class DeleteTest extends BaseControllerTest
{

    private $user;
    private $product;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();

        $this->product->carts()->attach($this->user->cart->id, [
            'quantity' => 1
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $product2 = Product::factory()->create();
        $product2->carts()->attach($this->user->cart->id, [
            'quantity' => 1
        ]);
        $response = $this->actingAs($this->user)->from(route('cart.show', $this->user->id))
            ->delete(route('cart.delete', $this->user->id), [
            'product_id' => $product2->id
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('cart.show', $this->user->id));

        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);

        $this->assertDatabaseMissing('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $product2->id,
            'quantity' => 1
        ]);
    }

    /**
     * Test return validation errors when data is not valid
     * @return void
     */
    public function testReturnWithErrorValidationWhenDataIsNotValid(): void
    {
        $product2 = Product::factory()->create();
        $response = $this->actingAs($this->user)->from(route('cart.show', $this->user->id))
            ->delete(route('cart.delete', $this->user->id), [
                'product_id' => $product2->id
            ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'product_id'
            ]);

        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $this->user->cart->id,
            'product_id' => $this->product->id,
            'quantity' => 1
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
        $response = $this->actingAs($this->user)->delete(route('cart.delete', $anotherUser->id));

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
        $response = $this->delete(route('cart.delete', $this->user->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
