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
        Schema::create('ponto_errado', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('empresa_cod');
            $table->char('matricula',100);
            $table->dateTime('data_entrada')->nullable();
            $table->dateTime('data_saida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ponto_errado');
    }
};
