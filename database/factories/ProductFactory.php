<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Gamme;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'gamme_id' => rand(1, Gamme::count()),
            'name' => $this->faker->words(1, true),
            'desc' => $this->faker->paragraph(1, true),
            'full_desc' => $this->faker->paragraph(3, true),
            'image' => 'default_picture' . rand(1, 11) . '.jpg',
            'price' => $this->faker->randomFloat(2, 2, 100),
            'dispo' => $this->faker->randomElement([0, 1])
        ];
    }
}