<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    const ESTADO = [
        '1' => 'Activo',
        '2' => 'Anulado',
    ];

    const TIPO_COMPROBANTE = [
        '1' => 'Factura',
        '2' => 'Ticket',
    ];

    const FORMA_PAGO = [
        '1' => 'Contado',
        '2' => 'Crédito',
    ];

    const MEDIO_PAGO = [
        '1' => 'Efectivo',
        '2' => 'Tarjeta Crédito',
        '3' => 'Tarjeta Débito',
        '4' => 'Cheque',
        '5' => 'Otro'
    ];

    use HasFactory;
}
