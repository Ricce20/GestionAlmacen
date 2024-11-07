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
        Schema::create('objeto_gastos', function (Blueprint $table) {
            $table->id();
            $table->string('cuenta');
            $table->string('concepto');
            $table->integer('vida');
            // $table->integer('depreciacion_anual');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('partida_especifica_id')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('partida_especifica_id')->references('id')->on('partidas_especificas')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objeto_gastos');
    }
};
