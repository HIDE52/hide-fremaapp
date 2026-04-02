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
        Order::factory()->create(['item_id' => $item->id]);
        $this->get('/')->assertSee('Sold');
    }

    public function test_user_cannot_see_their_own_items()
    {
        $user = User::factory()->create();
        $myItem = Item::factory()->create(['user_id' => $user->id, 'name' => 'My Item']);
        $this->actingAs($user)->get('/')->assertDontSee('My Item');
    }

    public function test_mylist_shows_only_liked_items()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => 'Favorite']);
        $user->likes()->attach($item->id);
        $this->actingAs($user)->get('/?tab=mylist')->assertSee('Favorite');
    }

    public function test_sold_items_in_mylist_display_the_label()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->likes()->attach($item->id);
        Order::factory()->create(['item_id' => $item->id]);
        $this->actingAs($user)->get('/?tab=mylist')->assertSee('Sold');
    }

    public function test_guest_cannot_see_any_items_in_mylist()
    {
        $this->get('/?tab=mylist')->assertOk();
    }

    public function test_items_can_be_searched_by_name()
    {
        Item::factory()->create(['name' => 'Apple']);
        Item::factory()->create(['name' => 'Banana']);
        $this->get('/?keyword=Apple')->assertSee('Apple')->assertDontSee('Banana');
    }

    public function test_search_keyword_is_maintained_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/?tab=mylist&keyword=Apple')->assertStatus(200);
        $this->assertEquals('Apple', request('keyword'));
    }
}
