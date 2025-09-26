<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('empresas')->onDelete('restrict');
            $table->foreignId('chart_of_account_id')->constrained()->onDelete('restrict');
            $table->foreignId('person_id')->nullable()->constrained('people_company')->onDelete('set null');
            $table->foreignId('payment_condition_id')->constrained('payment_conditions')->onDelete('restrict');
            $table->string('type', 20); // Ex.: "a pagar", "a receber"
            $table->decimal('amount', 15, 2);// Valor da transação
            $table->date('transaction_date'); // Data da transação
            $table->date('payment_date')->nullable(); // Data do pagamento, se aplicável
            $table->date('due_date')->nullable(); // Data de vencimento, se aplicável
            $table->text('description')->nullable();
            $table->string('status', 20)->default('open'); // Ex.: "aberta", "paga", "vencida"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};