<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_send_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/comment", ['comment' => 'Hello']);

        $this->assertDatabaseHas('comments', ['comment' => 'Hello']);
        $this->get("/item/{$item->id}")->assertSee('Hello');
    }

    /** @test */
    public function guest_user_cannot_send_comment()
    {
        $item = Item::factory()->create();
        $response = $this->post("/item/{$item->id}/comment", ['comment' => 'No login']);

        $this->assertDatabaseMissing('comments', ['comment' => 'No login']);
        $response->assertRedirect('/login');
    }
}
