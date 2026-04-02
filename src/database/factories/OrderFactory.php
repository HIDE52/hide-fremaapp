<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method' => 'コンビニ払い',
            'price' => 1000,
            // --- 以下の必須項目を追加 ---
            'postcode' => '123-4567',
            'address' => '東京都渋谷区道玄坂',
            'building' => 'コーテックビル', // buildingはnull可かもしれませんが念のため
        ];
    }
}
