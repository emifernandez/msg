<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Inactivo',
    ];

    const TIPO = [
        '1' => 'Venta',
        '2' => 'Insumo',
    ];

    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo_barra',
        'iva',
        'estado',
        'tipo',
        'unidad_id',
        'marca_id',
    ];

    public function setNombreAttribute($nombre)
    {
        $this->attributes['nombre'] = mb_strtolower($nombre, "UTF-8");
    }

    public function getNombreAttribute($nombre)
    {
        return ucwords($nombre);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function unidad()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_id');
    }
}
