<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Usamos classes do Tailwind para cores
        $tags = [
            ['name' => 'Backend', 'color' => 'bg-blue-500'],
            ['name' => 'Frontend', 'color' => 'bg-pink-500'],
            ['name' => 'Design UI/UX', 'color' => 'bg-purple-500'],
            ['name' => 'Mobile App', 'color' => 'bg-green-500'],
            ['name' => 'DevOps / Cloud', 'color' => 'bg-orange-500'],
            ['name' => 'Suporte / Hardware', 'color' => 'bg-gray-500'],
            ['name' => 'Consultoria', 'color' => 'bg-yellow-500'],
            ['name' => 'Banco de Dados', 'color' => 'bg-red-500'],
        ];

        foreach ($tags as $tag) {
            // updateOrCreate evita duplicar se rodar 2 vezes
            Tag::updateOrCreate(['name' => $tag['name']], $tag);
        }
    }
}