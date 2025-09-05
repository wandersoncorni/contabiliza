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
        Schema::create('faixas_faturamento', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('regime_tributario_id')->length(1)->comment('1 - Simples Nacional, 2 - Lucro Presumido');
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('descricao', 100);
            $table->string('hash', 256);
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('ativo', 1)->default(true);

            $table->unique(['regime_tributario_id', 'licensed_id', 'hash']);
        });
        Schema::create('naturezas_juridicas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 5);
            $table->string('descricao');
            $table->timestamps();
        });
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('people', 'id')->cascadeOnDelete();
            $table->foreignId('faixa_faturamento_id')->constrained('faixas_faturamento')->cascadeOnDelete();
            $table->foreignId('natureza_juridica_id')->constrained('naturezas_juridicas')->cascadeOnDelete();
            $table->foreignId('cnae_id')->constrained('cnae')->cascadeOnDelete();
            $table->foreignId('area_atividade_id')->length(1)->constrained('areas_atividade')->comment('1 - Comércio, 2 - Serviços');
            $table->foreignId('regime_tributario_id')->length(1)->constrained('regimes_tributarios')->comment('1 - Simples Nacional, 2 - Lucro Presumido');
            $table->string('nome_fantasia')->unique();
            $table->string('razao_social')->unique();
            $table->string('cnpj')->unique()->nullable();
            $table->decimal('capital_social', 15, 2);

            // Endereço
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('localidade');
            $table->string('estado');

            $table->string('inscricao_municipal')->nullable();
            $table->string('inscricao_estadual')->nullable();

            $table->date('data_abertura')->nullable();
            $table->string('tipo_inscricao')->nullable();  
            $table->string('numero_inscricao')->nullable();
            //Estado da solicitação de cadastro denova empresa
            $table->tinyInteger('status')->length(1)->default(4)->comment('0 - rejeitado, 1 - aprovado, 2 - pendente, 3 - cancelado, 4 - elaboração');
            //Situação cadastral
            $table->tinyInteger('situacao')->length(1)->default(4)->comment('0 - nula, 1 - ativa, 2 - suspensa, 3 - baixada, 4 - em processo de inscrição');

            $table->integer('total_funcionarios')->default(0);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
        Schema::dropIfExists('faixas_faturamento');
        Schema::dropIfExists('naturezas_juridicas');
    }
};
