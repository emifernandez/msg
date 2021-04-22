<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Actividades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('dias');
            $table->time('hora_inicio', $precision = 0);
            $table->time('hora_fin', $precision = 0);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('salon_id');
            $table->char('genero_habilitado', 1);
            $table->char('estado', 1);
            $table->timestamps();

            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios');
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleados');
            $table->foreign('salon_id')
                ->references('id')
                ->on('salones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
