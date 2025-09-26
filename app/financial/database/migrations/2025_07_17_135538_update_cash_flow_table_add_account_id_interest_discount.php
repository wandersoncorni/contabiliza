<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cash_flow', function (Blueprint $table) {
            // Adiciona os novos campos
            $table->foreignId('account_id')->constrained('accounts')->onDelete('restrict')->after('installment_id');// Relaciona com a conta bancária
            $table->decimal('interest', 15, 2)->default(0.00)->after('paid_amount');// Juros aplicados
            $table->decimal('discount', 15, 2)->default(0.00)->after('interest');// Desconto aplicado
        });
    }

    public function down(): void
    {
        Schema::table('cash_flow', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropColumn(['account_id', 'interest', 'discount']);
        });
    }
};