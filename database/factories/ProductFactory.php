<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word()),
            'quantity' => $this->faker->numberBetween(1,10),
            'price' => $this->faker->numberBetween(10,10000),
        ];
    }
}
