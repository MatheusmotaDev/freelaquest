<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete(); // Se apagar orçamento, apaga itens
            
            $table->string('description'); // Ex: "Desenvolvimento Frontend"
            $table->decimal('quantity', 10, 2)->default(1); // Ex: 10 (horas/unidades)
            $table->decimal('unit_price', 10, 2); // Ex: 150.00 (por hora)
            $table->decimal('total_price', 10, 2); // Ex: 1500.00 (Calculado)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};