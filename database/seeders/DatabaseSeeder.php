<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pega o seu usuário (ou cria um se não existir)
        // ATENÇÃO: Troque o email pelo que você usou no cadastro!
        $user = User::firstOrCreate(
            ['email' => 'matheusmota.webdev@gmail.com'], // <--- SEU EMAIL AQUI
            [
                'name' => 'Matheus',
                'password' => bcrypt('password'),
                'current_level' => 1,
                'current_xp' => 450, // Já começa com um pouco de XP pra testar
                'financial_goal_name' => 'Macbook Air',
                'financial_goal_amount' => 7000.00
            ]
        );

        // 2. Cria 5 Clientes para você
        Client::factory(5)
            ->for($user) // Vincula ao seu usuário
            ->has(
                // Cada cliente terá 2 Projetos
                Project::factory(2)
                    ->for($user)
                    ->has(
                        // Cada projeto terá 2 Faturas
                        Invoice::factory(2),
                        'invoices'
                    ),
                'projects'
            )
            ->create();

        $this->command->info('Tudo pronto! Banco populado com dados fake para o Matheus.');
    }
}