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
        Schema::create('regimes_bens', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('ativo', 1)->default(true);
        });
    }

    public function down(): void
    {        
        Schema::dropIfExists('regimes_bens');
    }
};