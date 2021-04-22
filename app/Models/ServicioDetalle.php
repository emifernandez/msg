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
}
