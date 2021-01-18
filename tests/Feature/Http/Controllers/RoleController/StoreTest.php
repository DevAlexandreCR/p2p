<?php

namespace Tests\Feature\Http\Controllers\RoleController;

use App\Constants\Permissions;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class StoreTest extends BaseControllerTest
{

    /**
     * Test an user whit permissions can create a role.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_ROLES);

        $response = $this->actingAs($this->admin)->post(route('roles.store'), [
            'name' => $role = 'new role'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('roles', [
            'name' => $role
        ]);
    }

    /**
     * Test an user without permissions can't  create a role.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->post(route('roles.store'), [
            'name' => $role = 'new role'
        ]);

        $response
            ->assertStatus(403)
            ->assertForbidden();

        $this->assertDatabaseMissing('roles', [
            'name' => $role
        ]);
    }

    /**
     * Test request key "name" should be string
     *
     * @return void
     */
    public function testValidateRequestKeyNameShouldBeString()
    {
        $this->admin->givePermissionTo(Permissions::CREATE_ROLES);

        $response = $this->actingAs($this->admin)->post(route('roles.store'), [
            'name' => $role = 1
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('roles', [
            'name' => $role
        ]);
    }

    /**
     * Test user unauthenticated is redirected to Login.
     *
     * @return void
     */
    public function testAnUserUnauthenticatedIsRedirectedToLogin()
    {
        $response = $this->post(route('roles.store'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
