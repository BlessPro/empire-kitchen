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
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date' => $startDate,
            'measurement_date' => $this->faker->dateTimeBetween($startDate, 'now'),
            'design_date' => $this->faker->dateTimeBetween($startDate, 'now'),
            'production_date' => $this->faker->dateTimeBetween($startDate, 'now'),
            'installation_date' => $this->faker->dateTimeBetween($startDate, 'now'),
            'first_assigned_tech_supervisor' => null,
            'second_assigned_tech_supervisor' => null,
            'first_assigned_designer' => null,
            'second_assigned_designer' => null,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'cost' => $this->faker->numberBetween(100000, 1000000),
        ];
    }

}


use App\Models\Project;

