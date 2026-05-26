<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    // 商品を購入できる
    public function test_商品を購入できる()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'コンビニ払い',
            'address' => 'テスト住所',
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // 購入した商品は商品一覧にてsoldと表示される
    public function test_購入した商品は商品一覧にてsoldと表示される()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'コンビニ払い',
            'address' => 'テスト住所',
        ]);

        $other = User::factory()->create();
        $response = $this->actingAs($other)->get('/');
        $response->assertSee('Sold');
    }

    // 購入した商品がプロフィールの購入した商品一覧に追加されている
    public function test_購入した商品がプロフィールの購入した商品一覧に追加されている()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'コンビニ払い',
            'address' => 'テスト住所',
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee($item->item_name);
    }

    // 支払い方法が選択できる
    public function test_支払い方法が選択できる()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $response = $this->actingAs($user)->get('/purchase/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee('コンビニ払い');
    }

    // 配送先住所が変更できる
    public function test_配送先住所が変更できる()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $response = $this->actingAs($user)->post('/purchase/address/' . $item->id, [
            'postal_code' => '987-6543',
            'address' => '新しい住所',
            'building' => '新しい建物',
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'address' => '新しい住所',
        ]);
    }

    // 購入した商品に送付先住所が紐づいている
    public function test_購入した商品に送付先住所が紐づいている()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create(['status' => '販売中']);

        $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => 'コンビニ払い',
            'address' => 'テスト住所',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}