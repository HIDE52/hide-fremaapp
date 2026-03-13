<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // ★この一行を追加してください！
use Illuminate\Support\Facades\Hash; // Hashを使う場合もこれも必要です

class LoginTest extends TestCase
{
    use RefreshDatabase; // ①

    /**
     * ① バリデーションと異常系のテスト（データセット形式）
     * @test
     * @dataProvider loginValidationProvider
     */
    public function test_login_validation($inputData, $errorMessage, $errorKey)
    {
        // ログイン画面へアクセス
        $this->get('/login');

        // データセットから受け取った「不正なデータ」を送信
        $response = $this->post('/login', $inputData);

        // 指定されたキーに、正しいエラーメッセージが含まれているか確認
        $response->assertSessionHasErrors([$errorKey => $errorMessage]);
    }

    /**
     * データセットの定義
     */
    public function loginValidationProvider()
    {
        return [
            'メールアドレスが未入力' => [
                ['email' => '', 'password' => 'password123'],
                'メールアドレスを入力してください',
                'email'
            ],
            // ★ここに追加します！
            'メールアドレスの形式が不備（@がない）' => [
                ['email' => 'test-example.com', 'password' => 'password123'],
                'メールアドレスはメール形式で入力してください',
                'email'
            ],
            'パスワードが未入力' => [
                ['email' => 'test@example.com', 'password' => ''],
                'パスワードを入力してください',
                'password'
            ],
            '未登録のメールアドレス' => [
                ['email' => 'unknown@example.com', 'password' => 'password123'],
                'ログイン情報が登録されていません',
                'email'
            ],
        ];
    }

    /**
     * ② 正常系のテスト（独立したメソッド）
     * @test
     */
    public function test_user_can_login_and_redirect_to_profile_setting()
    {
        // 事前にユーザーを一人作っておく（名簿に登録）
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'success@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 正しい情報でログイン
        $response = $this->post('/login', [
            'email' => 'success@example.com',
            'password' => 'password123',
        ]);

        // 【遷移の確認】プロフィール設定画面へ飛ばされたか [cite: 2026-03-02, 2026-03]
        $response->assertRedirect('/mypage/profile');

        // 【認証の確認】ログイン状態になっているか
        $this->assertAuthenticatedAs($user);
    }
}

