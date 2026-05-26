<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id'       => User::factory(),
            'profile_image' => null,
            'postal_code'   => '123-4567',
            'address'       => $this->faker->address(),
            'building'      => $this->faker->word(),
        ];
    }
}