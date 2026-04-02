<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_mypage_with_required_info()
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);
        $this->actingAs($user);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '私が出品した商品'
        ]);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('私が出品した商品');
    }

    public function test_user_can_see_profile_edit_page_with_default_values()
    {
        $user = User::factory()->create([
            'name' => '既存の名前',
            'postcode' => '111-1111',
            'address' => '東京都渋谷区'
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('既存の名前');
        $response->assertSee('111-1111');
        $response->assertSee('東京都渋谷区');
    }

    public function test_user_can_update_profile_information()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => '新しい名前',
            'postcode' => '999-9999',
            'address' => '大阪府大阪市'
        ];

        $this->actingAs($user)->post('/mypage/profile', $updateData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'address' => '大阪府大阪市'
        ]);
    }

    public function test_user_can_post_item()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::factory()->create(['content' => 'ファッション']);
        $image = UploadedFile::fake()->image('item.jpg');

        $itemData = [
            'categories'   => [$category->id],
            'condition'    => 1,
            'name'         => 'テスト出品商品',
            'brand_name'   => 'テストブランド',
            'description'  => '商品の説明文です',
            'price'        => 5000,
            'img_url'      => $image,
        ];

        $response = $this->actingAs($user)->post('/sell', $itemData);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('items', [
            'name' => 'テスト出品商品',
            'price' => 5000,
            'condition' => 1,
            'user_id' => $user->id
        ]);

        Storage::disk('public')->assertExists('items/' . $image->hashName());
    }
}
