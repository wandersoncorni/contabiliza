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
            $table->string('nome', 100);
            $table->string('descricao', 200)->nullable()->default(null);
            $table->string('valor', 10);
            $table->boolean('ativo', 1)->default(true);
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('descricao', 50)->nullable()->default(null);
            $table->boolean('ativo', 1)->default(true);
        });

        Schema::create('categorias_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->boolean('ativo', 1)->default(true);
        });
        // Relacionamneto entre planos de serviços e serviços
        Schema::create('plano_servico_categoria', function (Blueprint $table) {
            $table->foreignId('id_planos_servicos')->constrained('planos_servicos')->onDelete('cascade');
            $table->foreignId('id_categoria')->constrained('categorias_servicos')->onDelete('cascade');
            $table->foreignId('id_servicos')->constrained('servicos')->onDelete('cascade');
            $table->boolean('ativo', 1)->default(true);
            $table->timestamp('created_at')->useCurrent();
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
