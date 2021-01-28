<?php

namespace Tests\Feature\Http\Controllers\OrderController;

use App\Constants\PaymentGateway;
use App\Gateways\GatewayInterface;
use App\Gateways\MakeRequest;
use App\Gateways\PlaceToPay\PlaceToPay;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Mockery\MockInterface;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->withoutExceptionHandling();
        $this->instance(GatewayInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('create')->once();
        });
        $product = Product::factory()->create();
        $this->admin->cart->products()->attach($product->id, [
            'quantity' => 1
        ]);

        $response = $this->actingAs($this->admin)->post(route('users.orders.store', $this->admin->id), [
            'gateway_name' => PaymentGateway::PLACE_TO_PAY
        ]);

        $response
            ->assertStatus(302);
        $this
            ->assertDatabaseCount('orders', 1)
            ->assertDatabaseHas('order_product', [
                'product_id' => $product->id,
                'quantity'   => 1
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

        $response = $this->actingAs($this->admin)->post(route('users.orders.store', $anotherUser->id));

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
        $response = $this->get(route('users.orders.store', $this->admin->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
