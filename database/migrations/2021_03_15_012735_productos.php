<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('codigo_barra');
            $table->decimal('iva', $precision = 5, $scale = 2);
            $table->char('estado', 1);
            $table->unsignedBigInteger('unidad_id');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('grupo_id');
            $table->timestamps();

            $table->foreign('unidad_id')
                ->references('id')
                ->on('unidades_medidas');
            $table->foreign('marca_id')
                ->references('id')
                ->on('marcas');
            $table->foreign('grupo_id')
                ->references('id')
                ->on('grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
