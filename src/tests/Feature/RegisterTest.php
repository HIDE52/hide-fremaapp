<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_user_can_register_and_see_profile_setting_page()
    {
        $data = [
            'name' => 'テストユーザー',
            'email' => 'success@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->followRedirects($this->post('/register', $data));

        $this->assertDatabaseHas('users', ['email' => 'success@example.com']);
        $this->assertAuthenticated();
        $this->assertEquals(url('/mypage/profile'), url()->current());
        $response->assertStatus(200);
        $response->assertSee('プロフィール設定');
    }
}
