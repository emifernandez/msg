<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioDetalle extends Model
{
    use HasFactory;

    protected $table = 'servicio_detalle';
    protected $fillable = [
        'servicio_id',
        'precio',
        'iva'
    ];
    public $timestamps = false;

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function setPrecioAttribute($precio)
    {
        $this->attributes['precio'] = (int) str_replace('.', '', $precio);
    }

    public function getPrecioAttribute($precio)
    {
        return number_format($precio, 0, ',', '.');
    }

    public function setCantidadAttribute($cantidad)
    {
        $this->attributes['cantidad'] = (int) str_replace('.', '', $cantidad);
    }

    public function getCantidadAttribute($cantidad)
    {
        return number_format($cantidad, 0, ',', '.');
    }
}
