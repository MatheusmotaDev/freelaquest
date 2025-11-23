<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3), // Ex: "Criar Site Institucional"
            'description' => fake()->paragraph(),
            'deadline' => fake()->dateTimeBetween('now', '+3 months'),
            'total_amount' => fake()->randomFloat(2, 500, 10000), // Entre R$ 500 e 10k
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
        ];
    }
}