<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Trainee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AchievementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'platform' => $this->faker->randomElement(['مستقل', 'upwork', 'freelancer', 'خمسات']),
            'description' => $this->faker->name,
            'income' => $this->faker->randomFloat(1, 1, 499),
            'group_id' => Group::inRandomOrder()->first()->id,
            'trainee_id' => Trainee::inRandomOrder()->first()->id,
        ];
    }
}