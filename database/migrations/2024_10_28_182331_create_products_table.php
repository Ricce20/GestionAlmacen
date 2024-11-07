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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');//descripcion
            $table->string('brand')->nullable(); //marca
            $table->string('model')->nullable(); //modelo
            $table->string('serial_number')->nullable();//numero de serie
            $table->decimal('price');
            $table->decimal('valor_recidual')->nullable();
            $table->integer('vida_util');
            $table->string('Utj_id'); //UTJid
            $table->string('key');//clave
            // $table->unsignedBigInteger('acquisition_type_id');//tipo de alta
            $table->unsignedBigInteger('status_id');//status del producto
            $table->unsignedBigInteger('category_id');//status del producto
            $table->timestamps();

            //clave foranea
            // $table->foreign('acquisition_type_id')->references('id')->on('acquisition_types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
