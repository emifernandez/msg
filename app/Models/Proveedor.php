<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Inactivo',
    ];

    protected $table = 'proveedores';
    protected $fillable = [
        'razon_social',
        'descripcion',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'estado',
    ];
}
