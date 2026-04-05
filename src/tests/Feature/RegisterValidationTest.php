<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
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
            '名前が未入力' => [['name' => ''], 'お名前を入力してください', 'name'],
            '名前が20文字超過' => [['name' => str_repeat('a', 21)], 'お名前は20文字以内で入力してください', 'name'],
            'メールアドレスが未入力' => [['email' => ''], 'メールアドレスを入力してください', 'email'],
            'メールアドレスが形式不備' => [['email' => 'invalid-email'], 'メールアドレスはメール形式で入力してください', 'email'],
            'パスワードが未入力' => [['password' => '', 'password_confirmation' => ''], 'パスワードを入力してください', 'password'],
            'パスワードが7文字以下' => [['password' => '1234567', 'password_confirmation' => '1234567'], 'パスワードは8文字以上で入力してください', 'password'],
            'パスワードが確認用パスワードと一致しない' => [['password' => 'password123', 'password_confirmation' => 'diff'], 'パスワードと一致しません', 'password'],
        ];
    }
}
