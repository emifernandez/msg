<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'unidades_medidas';
    protected $fillable = [
        'nombre',
        'abreviacion'
    ];
    public $timestamps = false;

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = mb_strtolower($nombre, "UTF-8");
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords($nombre);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'unidad_id');
    }
}
