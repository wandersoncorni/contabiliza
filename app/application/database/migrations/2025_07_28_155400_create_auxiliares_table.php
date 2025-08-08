<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration de criação de tabelas auxiliares
     */
    public function up()
    {
        //Tabela de tipos de estado civil
        Schema::create('estados_civis', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->boolean('ativo', 1)->default(true);
        });
        //Tabela de estados do Brasil (UF)
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 2);
            $table->string('descricao');
            $table->boolean('ativo', 1)->default(true);
        });
        
        // Tabela de relacionamento entre sócios e empresas
        Schema::create('empresa_socio', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresas', 'id')->cascadeOnDelete();
            $table->foreignId('socio_id')->constrained('socios', 'id')->cascadeOnDelete();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {        
        Schema::dropIfExists('estados_civis');
        Schema::dropIfExists('estados');
    }
};