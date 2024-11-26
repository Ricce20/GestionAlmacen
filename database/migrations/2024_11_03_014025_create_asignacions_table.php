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
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_asignacion');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('ubicacion_id');
            $table->unsignedBigInteger('product_id');
            $table->date('fecha_finalizacion')->nullable();
            $table->boolean('devuelto')->nullable();
            $table->string('nota')->nullable();
            $table->boolean('activo');
            $table->enum('tipo_asignacion',['Transferido','Asignado']);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('ubicacion_id')->references('id')->on('ubicacions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacions');
    }
};
