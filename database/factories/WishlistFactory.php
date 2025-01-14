<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Wishlist;

class WishlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wishlist::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sub_total' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total' => $this->faker->randomFloat(2, 0, 99999999.99),
            'user_id' => User::factory(),
        ];
    }
}
