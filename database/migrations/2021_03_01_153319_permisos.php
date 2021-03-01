<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Permisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('acceso_id');
            $table->timestamps();

            $table->foreign('rol_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->foreign('acceso_id')
                ->references('id')
                ->on('accesos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
