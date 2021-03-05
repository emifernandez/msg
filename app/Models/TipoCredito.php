<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCredito extends Model
{
    use HasFactory;
    protected $table = 'tipos_creditos';
    protected $fillable = [
        'descripcion',
        'tasa_diaria',
        'tasa'
    ];
    public $timestamps = false;

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = mb_strtolower($descripcion, "UTF-8");
    }

    public function getDescripcionAttribute($descripcion)
    {
        return ucwords($descripcion);
    }
}
