<?php

namespace Database\Seeders;

use App\Models\Acceso;
use Illuminate\Database\Seeder;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acceso = new Acceso();
        $acceso->nombre = 'rol';
        $acceso->descripcion = 'Roles';
        $acceso->save();
    }
}
