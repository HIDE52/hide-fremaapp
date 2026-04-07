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
     * @test
     * @dataProvider commentProvider
     */
    public function comment_validation_on_screen($value, $errorMessage)
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
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
            'empty' => ['', 'コメントを入力してください'],
            'over_max' => [str_repeat('あ', 256), 'コメントは255文字以内で入力してください'],
        ];
    }
}
