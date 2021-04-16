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

        /*******************************************************/
        $menu = new Acceso();
        $menu->nombre = 'datos-basicos';
        $menu->descripcion = 'Datos Básicos';
        $menu->icono = 'fas fa-fw fa-cogs';
        $menu->nivel = 1;
        $menu->save();
        $acceso = new Acceso();
        $acceso->nombre = 'salon';
        $acceso->descripcion = 'Salones';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'salon.index';
        $acceso->icono = 'fas fa-fw fa-door-open';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'servicio';
        $acceso->descripcion = 'Servicios';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'servicio.index';
        $acceso->icono = 'fas fa-fw fa-calendar-check';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'tipo-credito';
        $acceso->descripcion = 'Tipos de Crédito';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'tipo-credito.index';
        $acceso->icono = 'fas fa-fw fa-file-invoice-dollar';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'cliente';
        $acceso->descripcion = 'Clientes';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'cliente.index';
        $acceso->icono = 'fas fa-fw fa-user-friends';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'ficha';
        $acceso->descripcion = 'Ficha Clientes';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'ficha.index';
        $acceso->icono = 'fas fa-fw fa-id-card';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'empleado';
        $acceso->descripcion = 'Empleados';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'empleado.index';
        $acceso->icono = 'fas fa-fw fa-user-tag';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'proveedor';
        $acceso->descripcion = 'Proveedores';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'proveedor.index';
        $acceso->icono = 'fas fa-fw fa-truck';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'producto';
        $acceso->descripcion = 'Productos';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'producto.index';
        $acceso->icono = 'fas fa-fw fa-box';
        $acceso->nivel = 2;
        $acceso->save();

        /*******************************************************/
        $menu = new Acceso();
        $menu->nombre = 'parametros';
        $menu->descripcion = 'Parámetros';
        $menu->icono = 'fas fa-fw fa-th-large';
        $menu->nivel = 1;
        $menu->save();
        $acceso = new Acceso();
        $acceso->nombre = 'marca';
        $acceso->descripcion = 'Marcas';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'marca.index';
        $acceso->icono = 'fas fa-fw fa-border-all';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'unidad';
        $acceso->descripcion = 'Unidades de Medida';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'unidad.index';
        $acceso->icono = 'fas fa-fw fa-ruler-combined';
        $acceso->nivel = 2;
        $acceso->save();
        $acceso = new Acceso();
        $acceso->nombre = 'grupo';
        $acceso->descripcion = 'Grupos';
        $acceso->modulo = $menu->id;
        $acceso->ruta = 'grupo.index';
        $acceso->icono = 'fas fa-fw fa-layer-group';
        $acceso->nivel = 2;
        $acceso->save();
    }
}
