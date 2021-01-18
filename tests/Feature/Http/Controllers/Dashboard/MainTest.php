<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Constants\Permissions;
use App\Constants\Roles;
use App\Models\User;
use Tests\Feature\Http\Controllers\BaseControllerTest;
use Illuminate\Foundation\Testing\WithFaker;

class MainTest extends BaseControllerTest
{
    use WithFaker;

    public function testRedirectToDashboardWhenLoginIfUserHasAnyRole()
    {
        $user = User::factory()->create([
            'email' => $email = $this->faker->email,
            'password' =>bcrypt($pass = $this->faker->password)
        ]);

        $user->assignRole(Roles::ADMIN);

        $response = $this->post(route('login'), [
            'email' => $email,
            'password' => $pass
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

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
