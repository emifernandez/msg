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
        $menu = new Acceso();
        $menu->nombre = 'administracion';
        $menu->descripcion = 'Administración';
        $menu->icono = 'fas fa-fw fa-tools';
        $menu->nivel = 1;
        $menu->save();
        $acceso = new Acceso();
        $acceso->nombre = 'rol';
        $acceso->descripcion = 'Roles';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'rol.index';
        $acceso->icono = 'fas fa-fw fa-users';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'usuario';
        $acceso->descripcion = 'Usuarios';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'usuario.index';
        $acceso->icono = 'fas fa-fw fa-user';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'cambiar-password';
        $acceso->descripcion = 'Cambiar Contraseña';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'password.request';
        $acceso->icono = 'fas fa-fw fa-unlock-alt';
        $acceso->target = '_blank';
        $acceso->nivel = 2;
        $acceso->save();
    }
}
