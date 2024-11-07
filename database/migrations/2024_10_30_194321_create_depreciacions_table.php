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
        Schema::create('depreciaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_calculo');
            $table->integer('anios')->nullable();
            $table->string('metodo');
            $table->decimal('porcentaje_depreciacion');
            $table->decimal('monto_depreciacion',10,2);
            $table->decimal('valor_libros',10,2);
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depreciacions');
    }
};
