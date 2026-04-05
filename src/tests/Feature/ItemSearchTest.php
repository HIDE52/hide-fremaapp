<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_search_items_by_name()
    {
        Item::factory()->create(['name' => 'Apple Watch']);
        Item::factory()->create(['name' => 'Sony Headphone']);

        $response = $this->get('/?keyword=Apple');

        $response->assertStatus(200);
        $response->assertSee('Apple Watch');
        $response->assertDontSee('Sony Headphone');
    }

    /** @test */
    public function search_keyword_is_retained_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/?tab=mylist&keyword=Apple');

        $response->assertStatus(200);
        $this->assertEquals('Apple', request('keyword'));
    }
}
