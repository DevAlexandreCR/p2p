<?php

namespace Tests\Feature\Http\Controllers\RoleController;

use App\Constants\Permissions;
use Spatie\Permission\Models\Role;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class UpdateTest extends BaseControllerTest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::EDIT_ROLES);

        $response = $this->actingAs($this->admin)->put(route('roles.update', Role::first()), [
            'name' => $name = 'role updated'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('roles', [
            'name' => $name
        ]);
    }

    /**
     * Test request key "name" should be string
     *
     * @return void
     */
    public function testValidateRequestKeyNameShouldBeString()
    {
        $this->admin->givePermissionTo(Permissions::EDIT_ROLES);

        $response = $this->actingAs($this->admin)->put(route('roles.update', Role::first()), [
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
        $response = $this->put(route('roles.update', Role::first()));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->put(route('roles.update', Role::first()));

        $response
            ->assertStatus(403)
            ->assertForbidden();
    }
}
