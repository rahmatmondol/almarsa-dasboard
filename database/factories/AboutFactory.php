<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\About;

class AboutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = About::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'banner_background' => $this->faker->word(),
            'banner_title' => $this->faker->word(),
            'banner_image' => $this->faker->word(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->word(),
            'about' => $this->faker->text(),
            'title' => $this->faker->sentence(4),
            'sub_title' => $this->faker->word(),
            'icons' => '{}',
            'image_cards' => '{}',
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
