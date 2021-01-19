<?php

namespace Tests\Feature\Http\Controllers\UserController;

use App\Constants\Permissions;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class IndexTest extends BaseControllerTest
{

    /**
     * @inheritDoc
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::VIEW_USERS);

        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.users.index')
            ->assertViewHas('users');
    }

    /**
     * @inheritDoc
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));

        $response
            ->assertStatus(403)
            ->assertForbidden();
    }

    /**
     * @inheritDoc
     */
    public function testAnUserUnauthenticatedIsRedirectedToLogin()
    {
        $response = $this->get(route('users.index'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
