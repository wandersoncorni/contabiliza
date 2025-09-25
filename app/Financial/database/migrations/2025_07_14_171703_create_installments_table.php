<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->integer('installment_number'); // Ex.: 1, 2, 3, etc.
            $table->decimal('amount', 15, 2); // Valor da parcela
            $table->date('due_date'); // Data de vencimento da parcela
            $table->date('payment_date')->nullable(); // Data de pagamento da parcela, pode ser nula se ainda não foi paga
            $table->string('status', 20)->default('open'); // Ex.: "aberta", "paga", "vencida"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};