<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_payment_method_reflects_in_database()
    {
        $mockIntent = (object)['id' => 'pi_test_123', 'status' => 'succeeded'];
        \Mockery::mock('alias:Stripe\PaymentIntent')->shouldReceive('create')->andReturn($mockIntent);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'payment_method' => 'convenience',
            'stripeToken' => 'tok_visa',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'item_id' => $item->id,
            'payment_method' => 'convenience',
        ]);
    }
}
