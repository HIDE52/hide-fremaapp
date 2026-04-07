<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
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
            'メールアドレスを入力してください' => [
                ['email' => '', 'password' => 'password123'],
                'メールアドレスを入力してください',
                'email'
            ],
            'パスワードを入力してください' => [
                ['email' => 'test@example.com', 'password' => ''],
                'パスワードを入力してください',
                'password'
            ],
            'メールアドレスはメール形式で入力してください' => [
                ['email' => 'invalid-email', 'password' => 'password123'],
                'メールアドレスはメール形式で入力してください',
                'email'
            ],
        ];
    }
}
