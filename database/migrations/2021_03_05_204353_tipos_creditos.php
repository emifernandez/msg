<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TiposCreditos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_creditos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('tasa_diaria', $precision = 5, $scale = 2);
            $table->decimal('tasa', $precision = 5, $scale = 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_creditos');
    }
}
