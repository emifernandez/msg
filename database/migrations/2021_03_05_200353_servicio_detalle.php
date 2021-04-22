<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServicioDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedInteger('cantidad');
            $table->decimal('precio', $precision = 8, $scale = 0);
            $table->decimal('iva', $precision = 5, $scale = 2);
            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_detalle');
    }
}
