<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // 持ち主を自動生成して紐付け
            'name' => 'テスト商品',
            'description' => 'テスト説明文',
            'price' => 1000,
            'condition' => $this->faker->numberBetween(1, 4), // これで「1〜4」のどれかが入る
            'img_url' => 'test.jpg',
        ];
    }
}
