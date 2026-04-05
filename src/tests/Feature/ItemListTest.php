<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_are_displayed_on_the_index_page()
    {
        Item::factory()->create(['name' => 'Other Item']);
        $this->get('/')->assertStatus(200)->assertSee('Other Item');
    }

    public function test_sold_items_display_the_sold_label()
    {
        $item = Item::factory()->create();
        Order::factory()->create([
            'item_id' => $item->id,
            'user_id' => User::factory()->create()->id,
            'price' => $item->price,
        ]);
        $this->get('/')->assertSee('Sold');
    }

    public function test_user_cannot_see_their_own_items()
    {
        $user = User::factory()->create();
        $myItem = Item::factory()->create(['user_id' => $user->id, 'name' => 'My Item']);
        $this->actingAs($user)->get('/')->assertDontSee('My Item');
    }
}
