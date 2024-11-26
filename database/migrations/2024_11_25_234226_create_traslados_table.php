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
        Schema::create('traslados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignacion_id');
            $table->date('fecha_inicio');
            $table->unsignedBigInteger('origen_employee_id');
            $table->unsignedBigInteger('origen_activo_id');
            $table->string('motivo_tralado')->nullable();
            $table->unsignedBigInteger('destinatario_employee_id');
            $table->string('nueva_ubicacion');
            $table->date('fecha_cierre')->nullable();
            $table->boolean('aceptado')->nullable();
            $table->string('motivo_destinatario')->nullable();
            $table->timestamps();

            $table->foreign('asignacion_id')->references('id')->on('asignacions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('origen_employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('origen_activo_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('destinatario_employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traslados');
    }
};
