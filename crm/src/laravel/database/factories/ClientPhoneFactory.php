<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientPhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phoneNumber' => '38096'. $this->faker->randomNumber(7, true ),
        ];
    }
}
