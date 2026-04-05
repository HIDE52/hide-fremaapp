<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider loginValidationProvider
     */
    public function test_login_validation($invalidData, $errorMessage, $errorKey)
    {
        $this->from('/login');
        $response = $this->post('/login', $invalidData);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([$errorKey => $errorMessage]);
    }

    public function loginValidationProvider()
    {
        return [
            'メールアドレスが未入力' => [
                ['email' => '', 'password' => 'password123'],
                'メールアドレスを入力してください',
                'email'
            ],
            'パスワードが未入力' => [
                ['email' => 'test@example.com', 'password' => ''],
                'パスワードを入力してください',
                'password'
            ],
            'メール形式不備' => [
                ['email' => 'invalid-email', 'password' => 'password123'],
                'メールアドレスはメール形式で入力してください',
                'email'
            ],
        ];
    }
}
