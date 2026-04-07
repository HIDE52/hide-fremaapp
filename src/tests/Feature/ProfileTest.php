<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_mypage_display_sell_items()
    {
        $user = User::factory()->create([
            'name' => 'テスト出品者',
            'email_verified_at' => now(),
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '私が出品した商品A'
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('テスト出品者');
        $response->assertSee('私が出品した商品A');
    }

    public function test_user_can_see_mypage_display_buy_items()
    {
        $user = User::factory()->create([
            'name' => 'テスト購入者',
            'email_verified_at' => now(),
        ]);

        $boughtItem = Item::factory()->create(['name' => '私が購入した商品B']);
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $boughtItem->id
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('テスト購入者');
        $response->assertSee('私が購入した商品B');
    }
}
