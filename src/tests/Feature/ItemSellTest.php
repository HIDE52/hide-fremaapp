<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemSellTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_post_item_from_item_sell_screen()
    {
        Storage::fake('public');
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $category = Category::factory()->create(['content' => 'ファッション']);
        $image = UploadedFile::fake()->image('item.jpg');

        $itemData = [
            'name'        => 'テスト商品',
            'description' => str_repeat('あ', 255),
            'price'       => 1000,
            'condition'   => 1,
            'categories'  => [$category->id],
            'img_url'     => $image,
        ];

        $response = $this->actingAs($user)->post('/sell', $itemData);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => str_repeat('あ', 255),
        ]);

        $item = Item::where('name', 'テスト商品')->first();
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);

        Storage::disk('public')->assertExists('items/' . $image->hashName());
    }
}
