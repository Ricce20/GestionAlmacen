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
        Schema::create('partidas_especificas', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('nombre_partida');
            $table->unsignedBigInteger('acquisition_type_id');//tipo de alta
            $table->unsignedBigInteger('product_id')->nullable();
            $table->dateTime('fecha_creacion');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
        
            $table->foreign('acquisition_type_id')->references('id')->on('acquisition_types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partida_especificas');
    }
};
