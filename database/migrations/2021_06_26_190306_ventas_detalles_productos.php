<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VentasDetallesProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalles_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad', $precision = 10, $scale = 2);
            $table->decimal('precio', $precision = 10, $scale = 0);
            $table->decimal('descuento', $precision = 10, $scale = 0);
            $table->decimal('monto_iva', $precision = 10, $scale = 0);
            $table->decimal('iva', $precision = 5, $scale = 2);
            $table->decimal('subtotal', $precision = 10, $scale = 0);

            $table->foreign('venta_id')
                ->references('id')
                ->on('ventas');
            $table->foreign('producto_id')
                ->references('id')
                ->on('reservas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_detalles_productos');
    }
}
