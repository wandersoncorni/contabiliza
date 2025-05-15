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
    Schema::create('socios', function (Blueprint $table) {
        $table->id(); // id_socio
        $table->string('nome');
        $table->boolean('resp_rf')->default(false); // Responsável Receita Federal
        $table->string('cpf')->unique();
        $table->string('profissao')->nullable();
        $table->string('estado_civil')->nullable();
        $table->string('regime_bens')->nullable();
        $table->decimal('participacao', 5, 2)->nullable(); // porcentagem
        $table->decimal('pro_labore', 10, 2)->nullable();

        // Endereço
        $table->string('logradouro')->nullable();
        $table->string('numero')->nullable();
        $table->string('complemento')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cep')->nullable();
        $table->string('estado')->nullable();
        $table->string('municipio')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
