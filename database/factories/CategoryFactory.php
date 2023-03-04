<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
        ];
    }
}
