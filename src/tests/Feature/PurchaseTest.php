<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_complete_purchase()
    {
        $mockIntent = (object)['id' => 'pi_test_123', 'status' => 'succeeded'];
        \Mockery::mock('alias:Stripe\PaymentIntent')->shouldReceive('create')->andReturn($mockIntent);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create(['price' => 2000]);

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'payment_method' => 'card',
            'stripeToken' => 'tok_visa',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_purchased_item_is_displayed_as_sold()
    {
        $item = Item::factory()->create(['name' => '完売テスト品']);
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/');

        $response->assertSee('sold');
    }

    public function test_purchased_item_appears_in_profile_list()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create(['name' => 'マイ購入品']);
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('マイ購入品');
    }
}
