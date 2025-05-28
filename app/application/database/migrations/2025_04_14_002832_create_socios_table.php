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
    // Tabela de relacionamento entre sócios e empresas
    Schema::create('socio_empresa', function (Blueprint $table) {
        $table->foreignId('id_empresa')->constrained('empresas', 'id')->cascadeOnDelete();
        $table->foreignId('id_socio')->constrained('socios', 'id')->cascadeOnDelete();
        $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamp('deleted_at')->nullable();
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
