<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            // ★ここを null にしておくことで、unverified() 関数が不要になります
            'email_verified_at' => null,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),

            // 自己完結型：DB制約でエラーが出ないよう、必須項目を網羅
            'postcode' => '123-4567',
            'address' => '東京都新宿区...',
            'building' => 'テストビル101',
        ];
    }
}
