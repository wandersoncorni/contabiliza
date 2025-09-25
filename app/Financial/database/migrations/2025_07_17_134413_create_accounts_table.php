<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('empresas')->onDelete('restrict');
            $table->string('bank_name', 100);
            $table->string('bank_code', 10);
            $table->string('agency', 10);
            $table->string('account_number', 20);
            $table->string('digit', 2)->nullable();
            $table->string('manager_name', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('account_type', 50)->nullable();
            $table->string('status', 20)->default('active');
            $table->string('pix_key', 100)->nullable();
            $table->text('integration_data')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};