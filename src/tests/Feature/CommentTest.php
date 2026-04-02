<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 要件1: ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_send_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comment.store', ['item_id' => $item->id]), [
                'comment' => 'テストコメントです'
            ]);

        // 保存されているか確認
        $this->assertDatabaseHas('comments', [
            'comment' => 'テストコメントです',
            'user_id' => $user->id
        ]);
        $response->assertStatus(302); // 元の画面へリダイレクト
    }

    /**
     * 要件2: ログイン前のユーザーはコメントを送信できない
     */
    public function test_guest_cannot_send_comment()
    {
        $item = Item::factory()->create();

        // ログインせずにPOST送信
        $response = $this->post(route('comment.store', ['item_id' => $item->id]), [
            'comment' => 'ゲストのコメント'
        ]);

        // DBに保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'comment' => 'ゲストのコメント'
        ]);
        // ログイン画面へ飛ばされることを期待（authミドルウェアの設定による）
        $response->assertRedirect('/login');
    }

    /**
     * 要件3: コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comment.store', ['item_id' => $item->id]), [
                'comment' => ''
            ]);

        $response->assertSessionHasErrors(['comment']);
    }

    /**
     * 要件4: コメントが255字以上の場合、バリデーションメッセージが表示される
     * ※「以上」なので256文字でテストします
     */
    public function test_comment_max_length_255()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 256文字を生成して送信
        $response = $this->actingAs($user)
            ->post(route('comment.store', ['item_id' => $item->id]), [
                'comment' => str_repeat('あ', 256)
            ]);

        $response->assertSessionHasErrors(['comment']);
    }
}
