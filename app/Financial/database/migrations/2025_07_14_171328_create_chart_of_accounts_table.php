<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // Ex.: "1.1.01"
            $table->string('name', 100);
            $table->string('type', 20); // Ex.: "asset", "liability", "revenue", "expense"
            $table->foreignId('parent_id')->nullable()->constrained('chart_of_accounts')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('empresas')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};