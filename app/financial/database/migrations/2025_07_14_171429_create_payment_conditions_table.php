<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('restrict');
            $table->foreignId('installment_interval_id')->constrained('installment_intervals')->onDelete('restrict');
            $table->string('description', 100); // Ex.: "À vista", "Parcelado em 3x", "Cartão de crédito", "Boleto bancário"
            $table->string('payment_type', 20); // Ex.: "dinheiro", "cartao", "boleto", "pix"
            $table->string('weekend_due_date', 20); // Dia não util=> Ex.: "keep", "next_business_day", "last_business_day"
            $table->string('display_in', 20); // Ex.: "compras", "vendas", "ambos"
            $table->boolean('issues_invoice')->default(false); // Ex.: "true" para emitir nota fiscal, "false" para não emitir
            $table->boolean('allows_down_payment')->default(false); // Ex.: "true" para permitir entrada, "false" para não permitir
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_conditions');
    }
};