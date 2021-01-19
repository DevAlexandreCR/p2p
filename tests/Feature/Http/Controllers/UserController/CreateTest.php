<?php

namespace Tests\Feature\Http\Controllers\UserController;

use App\Constants\Permissions;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class CreateTest extends BaseControllerTest
{

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_USERS);

        $response = $this->actingAs($this->admin)->get(route('users.create'));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.users.create');
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->get(route('users.create'));

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
        $response = $this->get(route('users.create'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
