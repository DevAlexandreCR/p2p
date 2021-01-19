<?php

namespace Tests\Feature\Http\Controllers\UserController;

use App\Constants\Permissions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{
    use WithFaker;

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_USERS);

        $response = $this->actingAs($this->admin)->post(route('users.store'), [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $pass = $this->faker->password,
            'password-confirm' => $pass
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('users.create'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'password' => $pass
        ]);
    }

    public function testResponseHasErrorsWhenDataIsNotValid()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_USERS);

        $response = $this->from(route('users.create'))
            ->actingAs($this->admin)->post(route('users.store'), [
            'name' => $name = 00,
            'email' => $email = $this->faker->name,
            'password' => $pass = 111,
            'password-confirm' => 222
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors([
                'name',
                'email',
                'password',
                'password-confirm'
            ]);

        $this->assertDatabaseMissing('users', [
            'name' => $name,
            'email' => $email,
            'password' => $pass
        ]);
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->post(route('users.store'), [
            'name' => $name = $this->faker->name
        ]);

        $response
            ->assertStatus(403)
            ->assertForbidden();

        $this->assertDatabaseMissing('users', [
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
        $response = $this->post(route('users.store'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
