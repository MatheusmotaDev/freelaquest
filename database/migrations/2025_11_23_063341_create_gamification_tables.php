<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Badges (As medalhas disponíveis no sistema)
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Primeiro Milhão"
            $table->string('icon_path')->nullable(); // Caminho da imagem
            $table->string('description');
            $table->string('rule_identifier')->unique(); // Código para o código saber qual regra aplicar (Ex: "EARN_1000")
            $table->integer('xp_bonus')->default(0); // XP extra ao ganhar
            $table->timestamps();
        });

        // 2. User Badges (Quem ganhou o quê)
        Schema::create('badge_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('unlocked_at');
        });

        // 3. Tags (Habilidades para a Skill Tree - Ex: Laravel, Design, Hardware)
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->default('#5865F2'); // Cor para o gráfico
            $table->timestamps();
        });

        // 4. Taggables (Liga Tags aos Projetos)
        // Polimórfica: permite ligar tags a Projetos hoje, e talvez a Clientes no futuro
        Schema::create('taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->morphs('taggable'); // Cria taggable_id e taggable_type
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('badge_user');
        Schema::dropIfExists('badges');
    }
};