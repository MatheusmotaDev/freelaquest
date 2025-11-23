<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona colunas de RPG
            $table->unsignedBigInteger('current_xp')->default(0)->after('email');
            $table->unsignedInteger('current_level')->default(1)->after('current_xp');
            
            // Meta Financeira (Gamificação do Macbook)
            $table->string('financial_goal_name')->nullable()->after('current_level'); // "Comprar PC"
            $table->decimal('financial_goal_amount', 10, 2)->nullable()->after('financial_goal_name'); // "5000.00"
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['current_xp', 'current_level', 'financial_goal_name', 'financial_goal_amount']);
        });
    }
};