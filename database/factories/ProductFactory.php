<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'sale_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'sku' => $this->faker->word(),
            'ribon' => $this->faker->word(),
            'productOptions' => '{}',
        ];
    }
}
