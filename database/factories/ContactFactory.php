<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'banner_background' => $this->faker->word(),
            'banner_title' => $this->faker->word(),
            'banner_image' => $this->faker->word(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'icons' => '{}',
        ];
    }
}
