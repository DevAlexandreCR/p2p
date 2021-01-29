<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Constants\Permissions;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class IndexTest extends BaseControllerTest
{
    use WithFaker;

    /**
     * Test search products
     * @return void
     */
    public function testAnUserWithPermissionsCanSearchProduct()
    {
        $this->refreshTestDatabase();

        $this->admin->givePermissionTo(Permissions::VIEW_PRODUCTS);

        Product::factory(15)->create();

        Product::factory()->create([
            'name' => $name = '$this->faker->word',
            'reference' => $reference = $this->faker->numerify('#####')
        ]);

        $response = $this->actingAs($this->admin)->get(route('products.index', [
            'name' => $name,
            'reference' => $reference
        ]));

        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.products.index')
            ->assertViewHas('products')
            ->assertSee($name)
            ->assertSee($reference);
    }
    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->withoutExceptionHandling();
        $this->admin->givePermissionTo(Permissions::VIEW_PRODUCTS);

        $response = $this->actingAs($this->admin)->get(route('products.index'));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.products.index')
            ->assertViewHas('products');
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->get(route('products.index'));

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
        $response = $this->get(route('products.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
