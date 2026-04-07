<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_redirects_to_verify_notice()
    {
        $data = [
            'name' => '成功ユーザー',
            'email' => 'success@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $data);

        $this->assertDatabaseHas('users', ['email' => 'success@example.com']);
        $this->assertAuthenticated();

        $response->assertRedirect('/home');
        $this->get('/home')->assertRedirect('/email/verify');
    }
}
