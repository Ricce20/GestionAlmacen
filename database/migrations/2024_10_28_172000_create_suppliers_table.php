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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('status');
            $table->string('RFC');
            $table->string('tipo_comprobante_fiscal');
            $table->string('domicilio');
            $table->string('colonia');
            $table->string('codigo_postal');
            $table->string('email')->unique();
            $table->string('telefono_1');
            $table->string('telefono_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
