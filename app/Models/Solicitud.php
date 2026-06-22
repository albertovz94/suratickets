<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'user_id',
        'tipo_equipo',
        'descripcion',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
