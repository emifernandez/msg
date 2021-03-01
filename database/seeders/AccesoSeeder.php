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
        $acceso->nombre = 'crear-rol';
        $acceso->descripcion = 'crear rol';
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'editar-rol';
        $acceso->descripcion = 'editar rol';
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'eliminar-rol';
        $acceso->descripcion = 'eliminar rol';
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'ver-rol';
        $acceso->descripcion = 'ver rol';
        $acceso->save();
    }
}
