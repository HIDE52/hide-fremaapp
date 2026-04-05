<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_item_information_is_displayed()
    {
        $user = User::factory()->create(['name' => 'コメント投稿者']);
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 12345,
            'description' => 'これはテストの説明文です',
            'condition' => '良好',
            'img_url' => 'https://example.com/test.jpg'
        ]);

        $category = Category::factory()->create(['content' => '電化製品']);
        $item->categories()->attach($category->id);

        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => '素晴らしい商品ですね！'
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥12,345');
        $response->assertSee('これはテストの説明文です');
        $response->assertSee('良好');
        $response->assertSee('電化製品');
        $response->assertSee('コメント(1)');
        $response->assertSee('コメント投稿者');
        $response->assertSee('素晴らしい商品ですね！');
        $response->assertSee('https://example.com/test.jpg');
    }

    /** @test */
    public function multiple_categories_are_displayed()
    {
        $item = Item::factory()->create();

        $cat1 = Category::factory()->create(['content' => 'ファッション']);
        $cat2 = Category::factory()->create(['content' => 'メンズ']);
        $item->categories()->attach([$cat1->id, $cat2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
