<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'user_id'     => User::factory(),
            'item_name'   => $this->faker->word(),
            'brand_name'  => $this->faker->word(),
            'price'       => $this->faker->numberBetween(100, 10000),
            'description' => $this->faker->sentence(),
            'condition'   => '良好',
            'status'      => '販売中',
            'item_image'  => 'https://via.placeholder.com/150',
        ];
    }
}