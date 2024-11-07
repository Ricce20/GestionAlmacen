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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('folio_factura');
            $table->dateTime('fecha_factura');
            $table->decimal('costo');
            // $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('objeto_gasto_id');
            $table->timestamps();

            // $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('objeto_gasto_id')->references('id')->on('objeto_gastos')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
