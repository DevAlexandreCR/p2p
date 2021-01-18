<?php

namespace Tests\Feature\Http\Controllers\RoleController;

use App\Constants\Permissions;
use App\Constants\Roles;
use Spatie\Permission\Models\Permission;
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
        $this->admin->assignRole(Roles::ADMIN);
        $role = Role::findByName(Roles::ADMIN);
        $permission = Permission::findByName(Permissions::CREATE_USERS);
        $response = $this->actingAs($this->admin)
            ->put(route('roles.update', $role->id), [
            'permissions' => [$permission->id]
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success');

        $this->assertTrue($this->admin->can(Permissions::CREATE_USERS));
    }

    /**
     * Test request key "name" should be string
     *
     * @return void
     */
    public function testResponseErrorsIfDataIsNotValid()
    {
        $this->admin->givePermissionTo(Permissions::EDIT_ROLES);
        $role = Role::findByName(Roles::ADMIN);
        $response = $this->actingAs($this->admin)->put(route('roles.update', $role->id), [
            'permissions' => [
                'not string',
                100000
            ]
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['permissions.*']);
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
