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
         * Cadastro de Valores dos Planos de Serviços
         * regime_tributario_id: 1 - Simples Nacional, 2 - Lucro Presumido
         * area_atividade_id: 1 - Comércio, 2 - Serviços
         */
        Schema::create('planos_servicos_valores', function (Blueprint $table) {  
            $table->id();          
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            $table->tinyInteger('area_atividade_id')->length(1)->comment('1 - Comércio, 2 - Serviços');
            $table->string('rotulo', 20);
            $table->decimal('valor', 10, 2);
            $table->boolean('ativo', 1)->default(true);

            $table->unique(['plano_servico_id', 'licensed_id', 'area_atividade_id', 'rotulo', 'ativo'], 'planos_servicos_valores_unique');
        });
        /*
         * Cadastro de adicionais dos planos. São indexadores adicionados aos planos e que alteram o seu valor
         * agrupamento_id: campo opcional para agrupar serviços adicionais. Os serviços com o mesmo agrupamento_id serão exibidos em lista.
         * Se não for informado, o serviço será exibido individualmente.
         */
        Schema::create('plano_servico_faixa_faturamento', function (Blueprint $table) {
            $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            $table->foreignId('faixa_faturamento_id')->constrained('faixas_faturamento')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('ativo', 1)->default(true);

            $table->primary(['plano_servico_id', 'faixa_faturamento_id', 'ativo']);
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
        /*
         * Cadastro de valores dos serviços
         */
        Schema::create('servicos_valores', function (Blueprint $table) {
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            $table->decimal('valor', 10, 2 )->nullable()->default(null);
            $table->string('condicoes', 50);
            $table->boolean('ativo', 1)->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['servico_id', 'plano_servico_id', 'ativo']);
        });
        // Cadastro de categorias de serviços
        Schema::create('categorias_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 50);
            $table->boolean('ativo', 1)->default(true);
        });
        // Relacionamneto entre planos de serviços e serviços
        Schema::create('plano_servico_categoria', function (Blueprint $table) {
            $table->unsignedBigInteger('plano_servico_id');
            $table->unsignedBigInteger('categoria_servico_id');
            $table->unsignedBigInteger('servico_id');
            $table->unsignedBigInteger('licensed_id');
            $table->string('observacao', 100)-> nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();

            $table->primary(['plano_servico_id', 'categoria_servico_id', 'servico_id']);

            $table->foreign('plano_servico_id')->references('id')->on('planos_servicos')->onDelete('cascade');
            $table->foreign('categoria_servico_id')->references('id')->on('categorias_servicos')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
            $table->foreign('licensed_id')->references('id')->on('licensed')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_servico_categoria');
        Schema::dropIfExists('planos_servicos_valores');
        Schema::dropIfExists('plano_servico_adicional');
        Schema::dropIfExists('planos_servicos_adicionais');
        Schema::dropIfExists('plano_servico_faixa_faturamento');
        
        Schema::dropIfExists('servicos_valores');
        Schema::dropIfExists('planos_servicos');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('categorias_servicos');
    }
};
