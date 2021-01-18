<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Constants\Permissions;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class MainTest extends BaseControllerTest
{

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::VIEW_DASHBOARD);

        $response = $this->actingAs($this->admin)->get(route('dashboard'));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.dashboard');
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->get(route('dashboard'));

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
        $response = $this->get(route('dashboard'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
