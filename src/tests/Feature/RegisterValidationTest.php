<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider registrationValidationProvider
     */
    public function test_registration_validation($invalidData, $errorMessage, $errorKey)
    {
        $validData = [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $data = array_merge($validData, $invalidData);
        $response = $this->post('/register', $data);

        $response->assertSessionHasErrors([$errorKey => $errorMessage]);
    }

    public function registrationValidationProvider()
    {
        return [
            'お名前を入力してください' => [
                ['name' => ''],
                'お名前を入力してください',
                'name'
            ],
            'お名前は20文字以内で入力してください' => [
                ['name' => str_repeat('a', 21)],
                'お名前は20文字以内で入力してください',
                'name'
            ],
            'メールアドレスを入力してください' => [
                ['email' => ''],
                'メールアドレスを入力してください',
                'email'
            ],
            'メールアドレスはメール形式で入力してください' => [
                ['email' => 'invalid-email'],
                'メールアドレスはメール形式で入力してください',
                'email'
            ],
            'パスワードを入力してください' => [
                ['password' => '', 'password_confirmation' => ''],
                'パスワードを入力してください',
                'password'
            ],
            'パスワードは8文字以上で入力してください' => [
                ['password' => '1234567', 'password_confirmation' => '1234567'],
                'パスワードは8文字以上で入力してください',
                'password'
            ],
            'パスワードと一致しません' => [
                ['password' => 'password123', 'password_confirmation' => 'diff'],
                'パスワードと一致しません',
                'password'
            ],
        ];
    }
}
