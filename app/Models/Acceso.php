<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    use HasFactory;
    protected $table = 'accesos';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function menu()
    {
        return $this->hasMany(Acceso::class, 'modulo');
    }
    public function submenus()
    {
        return $this->belongsTo(Acceso::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permisos')
            ->withPivot('crear')
            ->withPivot('eliminar')
            ->withPivot('modificar')
            ->withPivot('visualizar')
            ->withPivot('imprimir')
            ->withPivot('anular')
            ->as('permisos')
            ->withTimestamps();
    }
}
