<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'est_room_no' => $this->faker->randomNumber(),
            'est_name' => $this->faker->word,
            'est_zip' => $this->faker->postcode,
            'est_pref' => $this->faker->state,
            'est_city' => $this->faker->city,
        ];
    }
}
