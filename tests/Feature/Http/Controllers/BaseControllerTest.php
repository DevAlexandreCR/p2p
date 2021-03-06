<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed(TestDatabaseSeeder::class);
        $this->admin = User::factory()->create();
    }

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    abstract public function testAnUserWithPermissionsCanExecuteThisAction();

    /**
     * Test an user without permissions can't execute this action.
     *
     * @return void
     */
    abstract public function testAnUserWithoutPermissionsCannotExecuteThisAction();

    /**
     * Test user unauthenticated is redirected to Login.
     *
     * @return void
     */
    abstract public function testAnUserUnauthenticatedIsRedirectedToLogin();
}
