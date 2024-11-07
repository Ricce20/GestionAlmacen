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
        Schema::create('acquisition_types', function (Blueprint $table) {
            $table->id();
            $table->string('type'); //tipo de alta
            $table->boolean('es_tipo_venta')->nullable();
            $table->boolean('es_tipo_donativo')->nullable();
            $table->boolean('es_tipo_comodato')->nullable();
            $table->boolean('es_tipo_baja')->nullable();
            $table->boolean('es_tipo_compra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquisition_types');
    }
};
