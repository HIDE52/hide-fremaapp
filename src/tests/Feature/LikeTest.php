<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 【期待挙動 1⃣】
     * いいねした商品として登録され、いいね合計値が増加表示される
     */
    /** @test */
    public function item_can_be_liked_and_count_increases()
    {
        // 準備
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 実行：ログインしていいねを押す
        $this->actingAs($user)->post("/item/{$item->id}/like");

        // 検証：DBに登録されているか
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        // 検証：合計値が「1」になっているか
        $this->get("/item/{$item->id}")->assertSee('1');
    }

    /**
     * 【期待挙動 2⃣】
     * 追加済みのアイコンは色が変化する
     */
    /** @test */
    public function liked_icon_changes_color()
    {
        // 準備：あらかじめ「いいね」した状態を作る
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        // 実行：詳細ページを開く
        $this->actingAs($user)->get("/item/{$item->id}")
            // 検証：色が変化するクラス（is-liked）があるか確認
            ->assertSee('is-liked');
    }

    /**
     * 【期待挙動 3⃣】
     * 再度いいねアイコンを押下することによって、いいねを解除することができる
     */
    /** @test */
    public function item_can_be_unliked_and_count_decreases()
    {
        // 準備：あらかじめ「いいね」した状態を作る
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        // 実行：もう一度いいねを押す（解除操作）
        $this->actingAs($user)->post("/item/{$item->id}/like");

        // 検証：DBから消えているか
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        // 検証：合計値が「0」に戻っているか
        $this->get("/item/{$item->id}")->assertSee('0');
    }
}
