<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('empresas', function (Blueprint $table) {
        $table->id();
        $table->string('cnae')->nullable();
        $table->string('nome');
        $table->string('cnpj')->unique();
        $table->decimal('capital_social', 15, 2)->nullable();
        $table->string('area')->nullable();

        // Endereço
        $table->string('logradouro')->nullable();
        $table->string('numero')->nullable();
        $table->string('complemento')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cep')->nullable();
        $table->string('estado')->nullable();
        $table->string('municipio')->nullable();

        $table->string('inscricao_municipal')->nullable();
        $table->string('inscricao_estadual')->nullable();

        $table->date('data_abertura')->nullable();
        $table->string('tipo_inscricao')->nullable(); // JCE, OAB, etc
        $table->string('numero_inscricao')->nullable();
        $table->string('natureza_juridica')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
