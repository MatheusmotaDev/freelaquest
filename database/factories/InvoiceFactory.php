<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Entrada / Parcela',
            'amount' => fake()->randomFloat(2, 100, 5000),
            'due_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'status' => fake()->randomElement(['pending', 'paid']),
            // Se estiver pago, gera uma data de pagamento passada
            'paid_at' => function (array $attributes) {
                return $attributes['status'] === 'paid' ? fake()->dateTimeBetween('-1 month', 'now') : null;
            },
        ];
    }
}