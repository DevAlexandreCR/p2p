<?php

namespace Tests\Feature\Http\Controllers\UserController;

use App\Constants\Permissions;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class IndexTest extends BaseControllerTest
{
    use WithFaker;

    public function testAnUserWithPermissionsCanSearchUsers()
    {
        $this->admin->givePermissionTo(Permissions::VIEW_USERS);
        User::factory(30)->create();
        User::factory()->create([
            'name' => $name = $this->faker->name
        ]);

        $response = $this->actingAs($this->admin)->get(route('users.index', [
            'search' => $name
        ]));
        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard.users.index')
            ->assertViewHas('users')
            ->assertSee($name);
    }

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
