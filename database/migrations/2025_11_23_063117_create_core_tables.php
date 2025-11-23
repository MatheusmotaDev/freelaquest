<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela de Clientes
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Dono do cliente
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable(); // Para o WhatsApp
            $table->string('document')->nullable(); // CPF ou CNPJ
            $table->timestamps();
        });

        // 2. Tabela de Projetos
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable(); // Prazo de entrega
            $table->decimal('total_amount', 10, 2)->default(0); // Valor total (R$ 99999999.99)
            
            // Status usando ENUM (Texto fixo) para facilitar
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            
            $table->timestamps();
        });

        // 3. Tabela de Orçamentos (Quotes)
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            // Se este orçamento virar projeto, guardamos o ID do projeto aqui
            $table->foreignId('converted_to_project_id')->nullable()->constrained('projects')->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable(); // Escopo
            $table->decimal('amount', 10, 2);
            $table->date('valid_until')->nullable(); // Validade da proposta
            
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected'])->default('draft');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // A ordem reversa é importante para não dar erro de chave estrangeira
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('clients');
    }
};