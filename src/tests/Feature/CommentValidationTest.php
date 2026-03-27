<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentValidationTest extends TestCase
{
    // テスト実行ごとにデータベースをリセットしてクリーンにする設定
    use RefreshDatabase;

    /**
     * コメントが401文字以上の時にバリデーションエラーになるかテスト
     */
    public function test_comment_should_be_less_than_401_characters()
    {
        // 1. 準備（ユーザーと商品を用意する）
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 2. 実行（ログインした状態で401文字を送信する）
        $response = $this->actingAs($user)
            ->post(route('comment.store', ['item_id' => $item->id]), [
                'comment' => str_repeat('あ', 401), // 「あ」を401個生成
            ]);

        // 3. 検証（エラーがあるか、入力値が保持されているか）
        // commentフィールドにエラーがあることを確認
        $response->assertSessionHasErrors(['comment']);

        // 直前の入力値（401文字）がセッションに残っているか確認
        $this->assertEquals(str_repeat('あ', 401), old('comment'));
    }
}
