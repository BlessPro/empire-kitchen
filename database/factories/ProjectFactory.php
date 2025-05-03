<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'client_id' => Client::factory(), // Automatically creates a client
            'status' => $this->faker->randomElement(['pending', 'in progress', 'completed']),
            'start_date' => $this->faker->date(),
            'cost' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
