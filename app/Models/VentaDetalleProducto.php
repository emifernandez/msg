<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VentaDetalleProducto extends Pivot
{
    use HasFactory;

    protected $table = 'ventas_detalles_productos';
    public $incrementing = true;
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio',
        'descuento',
        'monto_iva',
        'iva',
        'subtotal',
        'descripcion',
        'codigo_barra',
    ];
    public $timestamps = false;

    public function setPrecioAttribute($precio)
    {
        $this->attributes['precio'] = (int) str_replace('.', '', $precio);
    }

    public function getPrecioAttribute($precio)
    {
        return number_format($precio, 0, ',', '.');
    }

    public function setMontoIvaAttribute($monto_iva)
    {
        $this->attributes['monto_iva'] = (int) str_replace('.', '', $monto_iva);
    }

    public function getMontoIvaAttribute($monto_iva)
    {
        return number_format($monto_iva, 0, ',', '.');
    }

    public function setDescuentoAttribute($descuento)
    {
        $this->attributes['descuento'] = (int) str_replace('.', '', $descuento);
    }

    public function getDescuentoAttribute($descuento)
    {
        return number_format($descuento, 0, ',', '.');
    }

    public function setCantidadAttribute($cantidad)
    {
        $this->attributes['cantidad'] = (int) str_replace('.', '', $cantidad);
    }

    public function getCantidadAttribute($cantidad)
    {
        return number_format($cantidad, 0, ',', '.');
    }

    public function getIvaAttribute($iva)
    {
        return number_format($iva, 0, ',', '.');
    }
}
