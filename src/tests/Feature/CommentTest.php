<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_send_comment()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/comment", ['comment' => 'こんにちは！']);

        $this->assertDatabaseHas('comments', ['comment' => 'こんにちは！']);
        $this->get("/item/{$item->id}")->assertSee('こんにちは！');
    }

    public function test_guest_user_cannot_send_comment()
    {
        $item = Item::factory()->create();
        $response = $this->post("/item/{$item->id}/comment", ['comment' => '未ログインの投稿']);

        $this->assertDatabaseMissing('comments', ['comment' => '未ログインの投稿']);
        $response->assertRedirect('/login');
    }
}
