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

        $user = User::factory()->create();
        $item = Item::factory()->create(['price' => 2000]);

        $response = $this->actingAs($user)->post(route('item.buy', ['item_id' => $item->id]), [
            'payment_method' => 'card',
            'stripeToken' => 'tok_visa',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response->assertRedirect(route('item.index'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'price' => 2000,
        ]);
    }

    public function test_purchased_item_is_displayed_as_sold()
    {
        $item = Item::factory()->create();
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get(route('item.index'));
        $response->assertSee('sold');
    }

    public function test_purchased_item_appears_in_profile_list()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'マイ購入品']);
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        $response = $this->actingAs($user)->get(route('mypage', ['page' => 'buy']));
        $response->assertStatus(200);
        $response->assertSee('マイ購入品');
    }

    public function test_selected_payment_method_reflects_in_database()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('item.buy', ['item_id' => $item->id]), [
            'payment_method' => 'convenience',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $this->assertDatabaseHas('orders', [
            'item_id' => $item->id,
            'payment_method' => 'convenience',
        ]);
    }
}
