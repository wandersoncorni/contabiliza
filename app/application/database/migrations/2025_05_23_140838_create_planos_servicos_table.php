<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cadastro de Planos de Serviços
        Schema::create('planos_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('descricao', 200)->nullable()->default(null);
            $table->boolean('ativo', 1)->default(true);
            $table->string('cor', 10);
            $table->tinyInteger('posicao');
        });
        /*
         * Tabela de registro de relacionamento entre planos de serviços, faixas de faturamento, regimes tributários e areas de atividade
         * O preço do plano de serviço é definido pela faixa de faturamento e regime tributário.
         */
        Schema::create('plano_servico_faixa_faturamento', function (Blueprint $table) {
            $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            $table->foreignId('faixa_faturamento_id')->constrained('faixas_faturamento')->onDelete('cascade');
            $table->foreignId('regime_tributario_id')->constrained('regimes_tributarios')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('ativo', 1)->default(true);

            $table->primary(['plano_servico_id', 'faixa_faturamento_id', 'regime_tributario_id', 'ativo']);
        });
        /*
         * Cadastro de serviços
         * Os serviços são os serviços que podem ser contratados pelos clientes.
         * Um serviço terá somente um valor. Se não for informado o valor, o serviço é considerado incorporado ao plano de serviços.
         * Se informado o valor, o serviço é considerado adicional ao plano de serviços e incidirá no valor do plano.
         */
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 100);
            $table->boolean('ativo', 1)->default(true);
        });
        // Cadastro de categorias de serviços
        Schema::create('categorias_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 50);
            $table->boolean('ativo', 1)->default(true);
        });
        /*
         * Cadastro de valores dos serviços
         */
        Schema::create('plano_categoria_servico', function (Blueprint $table) {
            $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            $table->foreignId('categoria_servico_id')->constrained('categorias_servicos')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->string('observacao', 100)-> nullable()->default(null);
            $table->decimal('valor', 10, 2 )->nullable()->default(null);
            $table->string('condicoes', 50)->nullable()->default(null);
            $table->boolean('ativo', 1)->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['plano_servico_id', 'categoria_servico_id', 'servico_id', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_servico_faixa_faturamento');
        Schema::dropIfExists('plano_categoria_servico');
        Schema::dropIfExists('planos_servicos');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('categorias_servicos');
    }
};
