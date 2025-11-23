<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            // --- BÁSICAS ---
            [
                'name' => 'Primeira Venda',
                'icon_path' => '💰',
                'description' => 'Recebeu o primeiro pagamento de um projeto.',
                'rule_identifier' => 'FIRST_INVOICE',
                'xp_bonus' => 500
            ],
            [
                'name' => 'High Ticket',
                'icon_path' => '💎',
                'description' => 'Fechou um pagamento único acima de R$ 2.000,00.',
                'rule_identifier' => 'HIGH_TICKET_2K',
                'xp_bonus' => 1000
            ],
            [
                'name' => 'O Início',
                'icon_path' => '🚀',
                'description' => 'Criou o primeiro projeto no sistema.',
                'rule_identifier' => 'FIRST_PROJECT',
                'xp_bonus' => 200
            ],
            [
                'name' => 'Fiel',
                'icon_path' => '🤝',
                'description' => 'Conquistou 3 clientes diferentes.',
                'rule_identifier' => '3_CLIENTS',
                'xp_bonus' => 1500
            ],

            // --- NOVAS (AVANÇADAS) ---
            [
                'name' => 'Veterano',
                'icon_path' => '⭐',
                'description' => 'Alcançou o Nível 5 de senioridade.',
                'rule_identifier' => 'LEVEL_5',
                'xp_bonus' => 2000
            ],
            [
                'name' => 'Magnata',
                'icon_path' => '🎩',
                'description' => 'Acumulou R$ 10.000,00 em ganhos totais.',
                'rule_identifier' => 'EARN_10K',
                'xp_bonus' => 3000
            ],
            [
                'name' => 'Workaholic',
                'icon_path' => '🔥',
                'description' => 'Manteve 3 projetos em andamento simultaneamente.',
                'rule_identifier' => '3_ACTIVE_PROJECTS',
                'xp_bonus' => 1000
            ],
            [
                'name' => 'Investidor',
                'icon_path' => '💸',
                'description' => 'Registrou a primeira despesa/investimento.',
                'rule_identifier' => 'FIRST_EXPENSE',
                'xp_bonus' => 300
            ]
        ];

        foreach ($badges as $badge) {
            Badge::firstOrCreate(['rule_identifier' => $badge['rule_identifier']], $badge);
        }
    }
}