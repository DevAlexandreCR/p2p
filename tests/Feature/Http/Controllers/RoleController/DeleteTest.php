<?php

namespace Tests\Feature\Http\Controllers\RoleController;

use App\Constants\Permissions;
use Spatie\Permission\Models\Role;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class DeleteTest extends BaseControllerTest
{

    /**
     * @inheritDoc
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $this->admin->givePermissionTo(Permissions::DELETE_ROLES);
        $role = Role::first();
        $response = $this->actingAs($this->admin)->delete(route('roles.destroy', $role->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('roles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('roles', [
            'name' => $role->name
        ]);
    }

    /**
     * @inheritDoc
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->delete(route('roles.destroy', Role::first()));

        $response
            ->assertStatus(403)
            ->assertForbidden();
    }

    /**
     * @inheritDoc
     */
    public function testAnUserUnauthenticatedIsRedirectedToLogin()
    {
        $response = $this->delete(route('roles.destroy', Role::first()));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
