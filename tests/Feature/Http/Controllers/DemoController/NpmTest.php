<?php

namespace Tests\Feature\Http\Controllers\DemoController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NpmTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get(route('demo.npm'));
        $response->assertViewIs('npm');
    }
}
