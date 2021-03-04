<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function accesos()
    {
        return $this->belongsToMany(Acceso::class, 'permisos')
            ->withPivot('crear')
            ->withPivot('eliminar')
            ->withPivot('modificar')
            ->withPivot('visualizar')
            ->withPivot('imprimir')
            ->withPivot('anular')
            ->as('permisos')
            ->withTimestamps();
    }

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = mb_strtolower($nombre, "UTF-8");
    }
}
