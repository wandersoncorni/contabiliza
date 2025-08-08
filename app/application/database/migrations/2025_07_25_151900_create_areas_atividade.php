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
        Schema::create('areas_atividade', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->boolean('ativo', 1)->default(true);
        });
    }

    public function down(): void
    {        
        Schema::dropIfExists('areas_atividade');
    }
};