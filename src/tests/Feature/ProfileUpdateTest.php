<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_page_shows_default_values()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'postcode' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル101');
    }

    public function test_user_can_update_profile_data()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $updateData = [
            'name' => '新しい名前',
            'postcode' => '999-9999',
            'address' => '大阪府大阪市',
            'building' => '新しいビル202',
        ];

        $response = $this->actingAs($user)->post('/mypage/profile', $updateData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'postcode' => '999-9999',
            'address' => '大阪府大阪市',
            'building' => '新しいビル202',
        ]);
    }
}
