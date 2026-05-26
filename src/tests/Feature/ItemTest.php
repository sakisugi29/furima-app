<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品一覧が表示される()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_自分が出品した商品は一覧に表示されない()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'status' => '販売中',
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertDontSee($item->item_name);
    }

    public function test_購入済み商品にはSoldと表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'status' => 'sold_out',
        ]);

        $other = User::factory()->create();
        $response = $this->actingAs($other)->get('/');
        $response->assertSee('Sold');
    }

    public function test_マイリストにはいいねした商品だけ表示される()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $other->id,
            'status' => '販売中',
        ]);

        $item->likes()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee($item->item_name);
    }

    public function test_未認証ユーザーのマイリストには何も表示されない()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
    }

    public function test_商品名で部分一致検索ができる()
    {
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'status' => '販売中',
        ]);

        $response = $this->get('/?search=テスト');
        $response->assertSee('テスト商品');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/?tab=mylist&search=テスト');
        $response->assertSee('テスト');
    }
}