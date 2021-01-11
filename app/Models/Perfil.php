<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';
    public $timestamps = false;

    protected $fillable = [
        'perfil',
    ];

    public function setPerfilAttribute($perfil) {
        $this->attributes['perfil'] = mb_strtolower($perfil, "UTF-8");

    }

    public function getPerfilAttribute($perfil) {
        return ucwords($perfil);
    }
}
