<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    // 出品商品情報が登録できる
    public function test_出品商品情報が登録できる()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        // カテゴリを事前に作成
        $category = \App\Models\Category::create(['name' => 'テストカテゴリ']);

        $response = $this->actingAs($user)->post('/sell', [
            'item_name'   => 'テスト商品',
            'brand_name'  => 'テストブランド',
            'price'       => 1000,
            'description' => 'テスト説明文',
            'condition'   => '良好',
            'categories'  => [$category->id],
            'item_image'  => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'user_id'   => $user->id,
            'item_name' => 'テスト商品',
            'price'     => 1000,
        ]);
    }

    // カテゴリが未選択の場合バリデーションメッセージが表示される
    public function test_カテゴリが未選択の場合バリデーションメッセージが表示される()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sell', [
            'item_name'   => 'テスト商品',
            'brand_name'  => 'テストブランド',
            'price'       => 1000,
            'description' => 'テスト説明文',
            'condition'   => '良好',
            'categories'  => [],
            'item_image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);
        $response->assertSessionHasErrors(['categories']);
    }

    // 商品名が未入力の場合バリデーションメッセージが表示される
    public function test_商品名が未入力の場合バリデーションメッセージが表示される()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sell', [
            'item_name'   => '',
            'brand_name'  => 'テストブランド',
            'price'       => 1000,
            'description' => 'テスト説明文',
            'condition'   => '良好',
            'categories'  => [1],
            'item_image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);
        $response->assertSessionHasErrors(['item_name']);
    }

    // 価格が未入力の場合バリデーションメッセージが表示される
    public function test_価格が未入力の場合バリデーションメッセージが表示される()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sell', [
            'item_name'   => 'テスト商品',
            'brand_name'  => 'テストブランド',
            'price'       => '',
            'description' => 'テスト説明文',
            'condition'   => '良好',
            'categories'  => [1],
            'item_image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);
        $response->assertSessionHasErrors(['price']);
    }

    // 商品状態が未選択の場合バリデーションメッセージが表示される
    public function test_商品状態が未選択の場合バリデーションメッセージが表示される()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sell', [
            'item_name'   => 'テスト商品',
            'brand_name'  => 'テストブランド',
            'price'       => 1000,
            'description' => 'テスト説明文',
            'condition'   => '',
            'categories'  => [1],
            'item_image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);
        $response->assertSessionHasErrors(['condition']);
    }
}