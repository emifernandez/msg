<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ventas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha');
            $table->integer('nro_factura')->nullable();
            $table->string('prefijo_factura')->nullable();
            $table->decimal('total', $precision = 10, $scale = 0);
            $table->decimal('total_iva10', $precision = 10, $scale = 0);
            $table->decimal('total_iva5', $precision = 10, $scale = 0);
            $table->decimal('total_iva0', $precision = 10, $scale = 0);
            $table->decimal('descuento', $precision = 10, $scale = 0);
            $table->char('estado', 1);
            $table->char('tipo_comprobante', 1);
            $table->char('forma_pago', 1);
            $table->char('medio_pago', 1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
