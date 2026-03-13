<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase

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
            '名前が未入力' => [
                ['name' => ''],
                'お名前を入力してください',
                'name'
            ],
            'メールアドレスが未入力' => [
                ['email' => ''],
                'メールアドレスを入力してください',
                'email'
            ],
            'メールアドレスが形式不備' => [
                ['email' => 'invalid-email'],
                'メールアドレスはメール形式で入力してください',
                'email'
            ],

            'パスワードが未入力' => [
                ['password' => ''],
                'パスワードを入力してください',
                'password'
            ],
            'パスワードが7文字以下' => [
                ['password' => '1234567', 'password_confirmation' => '1234567'],
                'パスワードは8文字以上で入力してください',
                'password'
            ],
            'パスワードが一致しない' => [
                ['password' => 'password123', 'password_confirmation' => 'password999'],
                'パスワードと一致しません',
                'password'
            ],
        ];
    }

    public function test_user_can_register_and_redirect_to_profile_setting()
    {
        $data = [
            'name' => 'テストユーザー',
            'email' => 'success@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $data);
        // 2. DBにデータが保存されたか確認（DB保存の確認）
        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'success@example.com',
        ]);
        // 3. 指定のURLへリダイレクトされたか確認（遷移の確認）
        $response->assertRedirect('/mypage/profile');
    }
    /**
     * @test
     * 既に登録されているメールアドレスは使用できない
     */
    public function test_email_must_be_unique()
    {
        // 1. 先に一人ユーザーを作っておく
        \App\Models\User::create([
            'name' => '既存ユーザー',
            'email' => 'duplicate@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. 同じメールアドレスで登録を試みる
        $data = [
            'name' => '新しい人',
            'email' => 'duplicate@example.com', // 同じアドレス
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $data);

        // 3. バリデーションエラー（emailの重複）が発生するか検証
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     * 会員登録完了後、自動的にログイン状態になる
     */
    public function test_user_is_authenticated_after_registration()
    {
        $data = [
            'name' => 'ログイン確認ユーザー',
            'email' => 'auth_test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->post('/register', $data);

        // ログイン状態であることを検証
        $this->assertAuthenticated();
  }
}