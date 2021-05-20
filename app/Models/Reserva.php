<?php

namespace App\Models;

use App\Formatters\DateFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    const ESTADO = [
        '1' => 'Reservado',
        '2' => 'Pagado',
        '3' => 'Cancelado',
    ];

    protected $table = 'reservas';
    protected $fillable = [
        'estado',
        'cliente_id',
        'evento_id',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
