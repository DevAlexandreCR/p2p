<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Constants\Permissions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{
    use WithFaker;

    /**
     * Test return errors when data is not valid
     * @return void
     */
    public function testResponseHasErrorsWhenDataIsNotValid()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_PRODUCTS);

        $response = $this->from(route('products.create'))
            ->actingAs($this->admin)->post(route('products.store'), [
                'name' => $name = 0,
                'description' => $description = $this->faker->firstName,
                'reference' => $reference = $this->faker->numerify('###'),
                'price' => $price = 0,
                'stock' => $stock = 0
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors([
                'name',
                'description',
                'reference',
                'price',
                'stock'
            ]);

        $this->assertDatabaseMissing('products', [
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'price' => $price,
            'stock' => $stock
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_PRODUCTS);

        $response = $this->actingAs($this->admin)->post(route('products.store'), [
            'name' => $name = $this->faker->firstName,
            'description' => $description = $this->faker->sentences(3, true),
            'reference' => $reference = $this->faker->numerify('#####'),
            'price' => $price = 20000,
            'stock' => $stock = 5
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.create'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'price' => $price,
            'stock' => $stock
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->post(route('products.store'), [
            'name' => $name = $this->faker->firstName
        ]);

        $response
            ->assertStatus(403)
            ->assertForbidden();

        $this->assertDatabaseMissing('products', [
            'name' => $name
        ]);
    }

    /**
     * Test user unauthenticated is redirected to Login.
     *
     * @return void
     */
    public function testAnUserUnauthenticatedIsRedirectedToLogin()
    {
        $response = $this->post(route('products.store'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
