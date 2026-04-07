<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedItem = Item::factory()->create(['name' => 'いいねした商品']);
        $notLikedItem = Item::factory()->create(['name' => '普通の商品']);

        $user->likes()->attach($likedItem->id);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('普通の商品');
    }

    public function test_sold_label_is_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => 'いいねした売切商品']);
        $user->likes()->attach($item->id);

        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('いいねした売切商品');
        $response->assertSee('Sold');
    }

    public function test_nothing_is_displayed_when_unauthenticated()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('いいねした商品');
    }
}
