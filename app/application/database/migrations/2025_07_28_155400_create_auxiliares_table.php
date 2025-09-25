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
        //Tabela de estados do Brasil (UF)
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 2);
            $table->string('descricao');
            $table->boolean('ativo', 1)->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};