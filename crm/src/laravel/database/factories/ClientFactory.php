<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fio' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'description' => $this->faker->paragraphs( 1, true),
            'user_id' => $this->faker->randomElement([null,1,2,3]),
        ];
    }
}
