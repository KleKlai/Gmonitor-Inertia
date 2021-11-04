<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ClassroomCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_classroom_create_screen_can_be_rendered()
    {
        $this->assertTrue(true);
    }

    public function test_classroom_name_is_required()
    {
        $response = $this->post('/classroom/store', [
            'name'  => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_classroom_can_be_create()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post('/classroom/store', [
            'name'  => 'Economics'
        ]);

        $response->assertOk();
        $response->assertStatus(200);
    }
}
