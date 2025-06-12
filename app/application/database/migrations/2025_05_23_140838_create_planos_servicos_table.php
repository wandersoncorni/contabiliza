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
        Schema::create('planos_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('descricao', 200)->nullable()->default(null);
            $table->decimal('valor_mensal', 10, 2);
            $table->decimal('valor_anual', 10, 2);
            $table->boolean('ativo', 1)->default(true);
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('descricao', 50)->nullable()->default(null);
            $table->boolean('ativo', 1)->default(true);
        });

        Schema::create('categorias_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licensed_id')->constrained('licensed')->onDelete('cascade');
            $table->string('nome', 50);
            $table->boolean('ativo', 1)->default(true);
        });
        // Relacionamneto entre planos de serviços e serviços
        Schema::create('plano_servico_categoria', function (Blueprint $table) {
            // $table->foreignId('plano_servico_id')->constrained('planos_servicos')->onDelete('cascade');
            // $table->foreignId('categoria_servico_id')->constrained('categorias_servicos')->onDelete('cascade');
            // $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');

            $table->unsignedBigInteger('plano_servico_id');
            $table->unsignedBigInteger('categoria_servico_id');
            $table->unsignedBigInteger('servico_id');
            $table->unsignedBigInteger('licensed_id');
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
        Schema::dropIfExists('planos_servicos');
        Schema::dropIfExists('servicos');
        Schema::dropIfExists('categorias_servicos');
    }
};
