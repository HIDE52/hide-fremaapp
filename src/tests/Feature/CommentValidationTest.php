<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider commentProvider
     */
    public function test_comment_validation($value, $errorMessage)
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->from("/item/{$item->id}")
            ->post("/item/{$item->id}/comment", [
                'comment' => $value
            ]);

        $response->assertStatus(302);
        $response->assertRedirect("/item/{$item->id}");
        $response->assertSessionHasErrors([
            'comment' => $errorMessage
        ]);
    }

    public function commentProvider()
    {
        return [
            'コメントを入力してください' => ['', 'コメントを入力してください'],
            'コメントは255文字以内で入力してください' => [str_repeat('あ', 256), 'コメントは255文字以内で入力してください'],
        ];
    }
}
