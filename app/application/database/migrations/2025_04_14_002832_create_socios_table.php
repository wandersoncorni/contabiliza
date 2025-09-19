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
        Schema::create('estados_civis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('ativo', 1)->default(true);
        });
        Schema::create('regimes_bens', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('ativo', 1)->default(true);
        });
        Schema::create('socios', function (Blueprint $table) {
            $table->id(); // id_socio
            $table->foreignId('client_id')->constrained('people')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('estado_civil_id')->nullable()->constrained('estados_civis')->cascadeOnDelete();
            $table->foreignId('regime_bens_id')->nullable()->constrained('regimes_bens')->cascadeOnDelete();
            $table->string('nome');
            $table->string('email')->nullable();
            $table->string('cpf');
            $table->string('profissao')->nullable();
            $table->string('telefone')->nullable();
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
            $table->softDeletes()->nullable()->default(null);

            $table->unique(['empresa_id', 'cpf']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_civis');
        Schema::dropIfExists('regimes_bens');
        Schema::dropIfExists('socios');
    }
};
