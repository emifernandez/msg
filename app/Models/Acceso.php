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

    public function roles()
    {
        return $this->belongsToMany(Rol::class)
            ->as('permisos')
            ->withTimestamps();
    }

}
