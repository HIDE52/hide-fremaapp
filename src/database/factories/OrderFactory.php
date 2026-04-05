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
            'payment_method' => 'card',
            'price' => 1000,
            'postcode' => '123-4567',
            'address' => '東京都渋谷区道玄坂',
            'building' => 'コーテックビル',
            'status' => 'succeeded',
            'stripe_id' => null,
        ];
    }
}
