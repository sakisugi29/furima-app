<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // ユーザー情報が取得できる
    public function test_ユーザー情報が取得できる()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    // プロフィール編集画面に初期値が表示される
    public function test_プロフィール編集画面に初期値が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);
        $profile = Profile::factory()->create([
            'user_id'     => $user->id,
            'postal_code' => '123-4567',
            'address'     => 'テスト住所',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('テスト住所');
    }
}