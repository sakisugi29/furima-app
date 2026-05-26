<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    // 商品詳細情報が表示される
    public function test_商品詳細情報が表示される()
    {
        $item = Item::factory()->create();

        $response = $this->get('/item/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee($item->item_name);
        $response->assertSee($item->brand_name);
        $response->assertSee(number_format($item->price));
    }

    // いいねができる
    public function test_いいねができる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/like');
        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // いいねを解除できる
    public function test_いいねを解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $item->likes()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/like');
        $response->assertStatus(302);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // ログイン済みユーザーはコメントを送信できる
    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => 'テストコメントです',
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメントです',
        ]);
    }

    // ログイン前のユーザーはコメントを送信できない
    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post('/item/' . $item->id . '/comment', [
            'comment' => 'テストコメントです',
        ]);

        $this->assertDatabaseMissing('comments', [
            'comment' => 'テストコメントです',
        ]);
    }

    // コメントが未入力の場合バリデーションメッセージが表示される
    public function test_コメントが未入力の場合バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => '',
        ]);
        $response->assertSessionHasErrors(['comment']);
    }

    // コメントが255文字以上の場合バリデーションメッセージが表示される
    public function test_コメントが255文字以上の場合バリデーションメッセージが表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/item/' . $item->id . '/comment', [
            'comment' => str_repeat('あ', 256),
        ]);
        $response->assertSessionHasErrors(['comment']);
    }
}