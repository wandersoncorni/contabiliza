<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('socios', function (Blueprint $table) {
        $table->id(); // id_socio
        $table->foreignId('client_id')->constrained('people')->cascadeOnDelete();
        $table->string('nome');
        $table->string('email')->nullable();
        $table->string('cpf')->unique();
        $table->string('profissao')->nullable();
        $table->string('telefone')->nullable();
        $table->string('estado_civil')->nullable();
        $table->string('regime_bens')->nullable();
        $table->decimal('participacao', 5, 2)->nullable(); // porcentagem
        $table->boolean('pro_labore')->nullable();
        $table->boolean('resp_rf')->default(false); // Responsável Receita Federal

        // Endereço
        $table->string('logradouro')->nullable();
        $table->string('numero')->nullable();
        $table->string('complemento')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cep')->nullable();
        $table->string('estado')->nullable();
        $table->string('localidade')->nullable();

        $table->timestamps();

        $table->unique(['client_id', 'cpf']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {        
        Schema::dropIfExists('socio_empresa');
        Schema::dropIfExists('socios');
    }
};
