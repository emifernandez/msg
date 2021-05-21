<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';
    protected $fillable = [
        'lote',
        'producto_id',
        'cantidad_actual',
        'cantidad_minima',
        'cantidad_maxima',
        'precio_compra',
        'precio_venta'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
