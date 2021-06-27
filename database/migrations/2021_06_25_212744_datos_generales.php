<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatosGenerales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_generales', function (Blueprint $table) {
            $table->string('prefijo_factura')->nullable();
            $table->unsignedInteger('nro_factura_desde')->nullable();
            $table->unsignedInteger('nro_factura_hasta')->nullable();
            $table->unsignedInteger('ultima_factura_impresa')->nullable();
            $table->string('timbrado')->nullable();
            $table->date('inicio_vigencia_timbrado')->nullable();
            $table->date('fin_vigencia_timbrado')->nullable();
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('ruc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_generales');
    }
}
