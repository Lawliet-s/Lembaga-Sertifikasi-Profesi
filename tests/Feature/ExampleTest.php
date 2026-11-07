<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SiteSetting;
use Spatie\Permission\Models\Role;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        Role::create(['name' => 'asesi']);
        Role::create(['name' => 'asesor']);
        SiteSetting::create([
            'title' => 'LSP Test',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
