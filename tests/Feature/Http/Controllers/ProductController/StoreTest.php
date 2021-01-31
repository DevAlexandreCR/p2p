<?php

namespace Tests\Feature\Http\Controllers\ProductController;

use App\Constants\Permissions;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{
    use WithFaker;

    /**
     * Test return errors when data is not valid
     * @dataProvider requiredFormValidationProvider
     * @param $formInput
     * @param $formInputValue
     * @return void
     */
    public function testResponseHasErrorsWhenDataIsNotValid($formInput, $formInputValue)
    {
        $this->admin->givePermissionTo(Permissions::CREATE_PRODUCTS);

        Product::factory()->create([
            'reference' => '1111'
        ]);

        $response = $this->from(route('products.create'))
            ->actingAs($this->admin)->post(route('products.store'), [$formInput => $formInputValue]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.create'))
            ->assertSessionHasErrors($formInput);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        Storage::fake('images');

        $this->admin->givePermissionTo(Permissions::CREATE_PRODUCTS);

        $response = $this->actingAs($this->admin)->post(route('products.store'), [
            'name' => $name = $this->faker->firstName,
            'description' => $description = $this->faker->sentences(3, true),
            'reference' => $reference = $this->faker->numerify('#####'),
            'price' => $price = 20000,
            'stock' => $stock = 5,
            'image' => UploadedFile::fake()->image('image.jpg')
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
            'stock' => $stock,
            'image' => 'image.jpg'
        ]);

        Storage::disk('images')->assertExists('image.jpg');
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

    public function requiredFormValidationProvider(): array
    {
        return [
            ['name', 1234],
            ['name', 'l'],
            ['name', 'more of thirty characters, validation should fail'],
            ['description', ''],
            ['description', 'less 10'],
            ['reference', null],
            ['reference', '1111'],
            ['reference', 'more than ten characters'],
            ['reference', '1111'],
            ['stock', ''],
            ['stock', 'uno'],
            ['stock', -1],
            ['price', -1],
            ['price', ''],
            ['image', 'image'],
            ['image', ''],
        ];
    }
}
