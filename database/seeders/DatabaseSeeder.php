<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar o Usuário Admin (Você!)
        // Se ele já existir, o updateOrCreate apenas atualiza os dados
        User::updateOrCreate(
            ['email' => 'admin@freelaquest.com'], // Mude para seu email se preferir
            [
                'name' => 'Admin Supremo',
                'password' => bcrypt('251004math'), // Senha padrão
                'is_admin' => true,
                
                // Dados padrão de Gamificação (para não dar erro)
                'current_xp' => 1000,
                'current_level' => 5,
                'financial_goal_name' => 'Dominação Mundial',
                'financial_goal_amount' => 1000000
            ]
        );

        
        $this->call([
            TagSeeder::class,
            BadgeSeeder::class,
        ]);
    }
}