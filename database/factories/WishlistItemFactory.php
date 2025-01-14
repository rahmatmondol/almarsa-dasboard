<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\WishlistItem;

class WishlistItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WishlistItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'wishlist_id' => Wishlist::factory(),
        ];
    }
}
