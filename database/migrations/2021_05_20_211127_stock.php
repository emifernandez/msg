<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('lote');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad_actual', $precision = 12, $scale = 2);
            $table->decimal('cantidad_minima', $precision = 12, $scale = 2);
            $table->decimal('cantidad_maxima', $precision = 12, $scale = 2)->nullable();
            $table->decimal('precio_compra', $precision = 10, $scale = 0);
            $table->decimal('precio_venta', $precision = 10, $scale = 0);
            $table->timestamps();

            $table->foreign('producto_id')
                ->references('id')
                ->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
