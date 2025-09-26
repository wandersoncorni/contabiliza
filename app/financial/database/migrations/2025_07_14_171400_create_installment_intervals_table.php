<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installment_intervals', function (Blueprint $table) {
            $table->id();
            $table->integer('installment'); // Número de parcelas
            $table->integer('interval'); // Intervalo em dias entre parcelas
            $table->decimal('percentage', 5, 2); // Percentual de cada parcela
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installment_intervals');
    }
};