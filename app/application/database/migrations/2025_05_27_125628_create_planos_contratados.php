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
        Schema::create('planos_servicos_contratados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('people')->onDelete('cascade');
            $table->longText('plano');
            $table->string('pagamento')->default(json_encode([]));
            $table->boolean('ativo')->nullable()->default(null);//Se null entao o plano é considerado em elaboração. Se 0, plano inativo. Se 1, plano ativo
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos_servicos_contratados');
    }
};
