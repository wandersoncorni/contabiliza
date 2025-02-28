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
        Schema::create('associados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('pessoas')->onDelete('cascade');
            $table->integer('associated_id')->constrained('pessoas')->onDelete('cascade');
            $table->timestamps();

            // Impede que uma pessoa seja pai de si mesma
            $table->unique(['client_id', 'associated_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associados');
    }
};
