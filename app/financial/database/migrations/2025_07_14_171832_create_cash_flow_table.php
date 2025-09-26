<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_flow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('empresas')->onDelete('restrict');
            $table->foreignId('chart_of_account_id')->constrained('chart_of_accounts')->onDelete('restrict');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->foreignId('installment_id')->nullable()->constrained('installments')->onDelete('set null');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('restrict'); // Relaciona com a conta bancária
            $table->decimal('amount', 15, 2); // Valor original da conta/parcela
            $table->decimal('paid_amount', 15, 2); // Valor efetivamente pago
            $table->decimal('interest', 15, 2)->default(0.00); // Juros aplicados
            $table->decimal('discount', 15, 2)->default(0.00); // Desconto aplicado
            $table->string('type', 20); // Ex.: "credito", "debito", "transferencia"
            $table->date('transaction_date');
            $table->text('description')->nullable(); // Ex.: "Pagamento com desconto de R$ 50"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_flow');
    }
};