<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_changed_address_is_shown_on_purchase_screen()
    {
        $user = User::factory()->create(['address' => '元の住所']);
        $item = Item::factory()->create();

        $newAddress = '東京都世田谷区赤堤';
        $this->actingAs($user)->post(route('address.update', ['item_id' => $item->id]), [
            'postcode' => '111-1111',
            'address'  => $newAddress,
        ]);

        $response = $this->get(route('item.purchase', ['item_id' => $item->id]));
        $response->assertSee($newAddress);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'address' => '元の住所']);
    }

    public function test_order_is_linked_with_session_address()
    {
        $mockIntent = (object)['id' => 'pi_test', 'status' => 'succeeded'];
        \Mockery::mock('alias:Stripe\PaymentIntent')->shouldReceive('create')->andReturn($mockIntent);

        $user = User::factory()->create();
        $item = Item::factory()->create();

        $newAddress = '東京都世田谷区赤堤';

        $this->actingAs($user)->post(route('address.update', ['item_id' => $item->id]), [
            'postcode' => '111-1111',
            'address'  => $newAddress,
        ]);

        $this->actingAs($user)->post(route('item.buy', ['item_id' => $item->id]), [
            'payment_method' => 'card',
            'stripeToken'    => 'tok_visa',
            'postcode'       => '111-1111',
            'address'        => $newAddress,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'address' => $newAddress,
        ]);
    }
}
