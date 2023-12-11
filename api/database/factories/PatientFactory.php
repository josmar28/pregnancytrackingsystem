<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patients>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $first_name = fake()->name();
        $last_name = fake()->name();

        return [
            'first_name' => $first_name,
			'last_name' => $last_name,
			'gender' => fake()->randomElement($array = array ('male', 'female')),
			'contact' => fake()->phoneNumber,
			'status' => fake()->randomElement($array = array ('active', 'inactive')),
        ];
    }
}
