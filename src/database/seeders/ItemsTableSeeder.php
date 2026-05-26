<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::create([
            'user_id' => 2,
            'item_name' => '腕時計',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'brand_name' => 'Rolax',
            'price' => 15000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'status' => '販売中',
        ]);
        $item->categories()->attach([
            Category::where('name', 'ファッション')->first()->id,
            Category::where('name', 'メンズ')->first()->id
        ]);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'brand_name' => '西芝',
            'price' => 5000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', '家電')->first()->id);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => '玉ねぎ3束',
            'description' => '新鮮な玉ねぎの3束セット',
            'brand_name' => '',
            'price' => 300,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', 'キッチン')->first()->id);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'brand_name' => '',
            'price' => 4000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
            'status' => '販売中',
        ]);
        $item->categories()->attach([
            Category::where('name', 'ファッション')->first()->id,
            Category::where('name', 'メンズ')->first()->id
        ]);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'brand_name' => '',
            'price' => 45000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', '家電')->first()->id);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'brand_name' => 'なし',
            'price' => 8000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', '家電')->first()->id);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'brand_name' => '',
            'price' => 3500,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
            'status' => '販売中',
        ]);
        $item->categories()->attach([
            Category::where('name', 'ファッション')->first()->id,
            Category::where('name', 'レディース')->first()->id
        ]);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'brand_name' => 'なし',
            'price' => 500,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', 'キッチン')->first()->id);

        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'brand_name' => 'Starbacks',
            'price' => 4000,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', 'キッチン')->first()->id);


        $item = Item::create([
            'user_id' => 2,
            'item_name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'brand_name' => '',
            'price' => 2500,
            'item_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし',
            'status' => '販売中',
        ]);
        $item->categories()->attach(Category::where('name', 'レディース')->first()->id);
}
}

