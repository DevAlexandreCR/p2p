<?php

namespace Tests\Feature\Http\Controllers\OrderController;

use App\Models\User;
use Tests\Feature\Http\Controllers\BaseControllerTest;

class IndexTest extends BaseControllerTest
{

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithPermissionsCanExecuteThisAction()
    {
        $response = $this->actingAs($this->admin)->get(route('users.orders.index', $this->admin->id));

        $response
            ->assertStatus(200)
            ->assertViewIs('home.users.orders.index')
            ->assertViewHas('orders');
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    public function testAnUserWithoutPermissionsCannotExecuteThisAction()
    {
        $anotherUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('users.orders.index', $anotherUser->id));

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
        $response = $this->get(route('users.orders.index', $this->admin->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
