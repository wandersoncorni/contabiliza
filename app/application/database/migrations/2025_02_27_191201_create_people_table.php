<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Extensao de users
     */
    public function up(): void
    {
        /**
         * Cria a tabela pessoas.
         * Caracteristicas:
         * - Eh um complemento a tabela de usuários.
         * - A chave estrangeira user_id referencia a tabela de usuários.
         * - O campo roles indica o perfil da pessoa.
         */
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('people', 'id')->cascadeOnDelete();
            $table->foreignId('licensed_id')->nullable()->constrained('licensed', 'id')->onDelete('cascade'); 
            $table->string('name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('photo', 20)->nullable();
            $table->string('roles', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
