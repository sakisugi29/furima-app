<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'テストユーザー1',
            'email'=>'test1@example.com',
            'password'=>Hash::make('password'),
        ]);

        User::create([
            'name'=>'テストユーザー2',
            'email'=>'test2@example.com',
            'password'=>Hash::make('password'),
        ]);
    }
}
