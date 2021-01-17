<?php

namespace Tests\Feature\Http\Controllers\RoleController;

use App\Constants\Permissions;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class IndexTest extends BaseControllerTest
{

    /**
     * Test user with permission can see roles list.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::VIEW_ROLES);

        $response = $this->actingAs($this->admin)->get(route('roles.index'));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.roles.index')
            ->assertViewHas('roles');
    }

    /**
     * Test user without permission can't see roles list.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {

        $response = $this->actingAs($this->admin)->get(route('roles.index'));

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
        $response = $this->get(route('roles.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
