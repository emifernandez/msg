<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';
    protected $fillable = [
        'descripcion',
    ];
    public $timestamps = false;

    public function detalle()
    {
        return $this->hasMany(ServicioDetalle::class, 'servicio_id');
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = mb_strtolower($descripcion, "UTF-8");
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords($descripcion);
    }
}
