<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'start_date' => $this->faker->date,
            'end_date'   => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
            'financier' => $this->faker->name,
        ];
    }
}
