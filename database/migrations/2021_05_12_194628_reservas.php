<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->char('estado', 1);
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('evento_id');
            $table->timestamps();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes');
            $table->foreign('evento_id')
                ->references('id')
                ->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
