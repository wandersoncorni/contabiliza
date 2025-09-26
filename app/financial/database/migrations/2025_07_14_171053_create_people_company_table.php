<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('empresas')->onDelete('restrict'); // Relaciona com empresas
            $table->string('name', 100);
            $table->string('tax_id', 20)->nullable(); // CPF ou CNPJ
            $table->string('type', 20); // Ex.: "cliente", "fornecedor", "transportadora"
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('zipcode', 10)->nullable(); // CEP
            $table->string('address', 100)->nullable(); // Logradouro
            $table->string('complement', 50)->nullable();// Complemento
            $table->string('district', 50)->nullable(); // Bairro
            $table->string('number', 20)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state_registration', 20)->nullable(); // RG ou Inscrição Estadual
            $table->string('trade_name', 100)->nullable(); // Nome fantasia
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people_company');
    }
};