<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Faturas (Receitas)
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            
            $table->string('title'); // Ex: "Entrada 50%"
            $table->decimal('amount', 10, 2);
            $table->date('due_date'); // Vencimento
            $table->date('paid_at')->nullable(); // Data que pagou (se null, não pagou)
            
            // Status para controle visual e lógica de bloqueio
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            
            $table->timestamps();
        });

        // 2. Despesas (Custos do Projeto)
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            
            $table->string('description'); // Ex: "Hospedagem AWS"
            $table->decimal('amount', 10, 2);
            $table->date('incurred_date'); // Data da despesa
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('invoices');
    }
};