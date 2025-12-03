<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Nombre de la tabla (si no sigue la convención plural de 'usuarios')
    protected $table = 'usuarios';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'email',
        'password',
        'nombres',
        'apellidos',
        'rol',
        'estado',
        'ultimo_acceso',
    ];

    // Si no usas timestamps (created_at y updated_at)
    public $timestamps = true;

    // Si quieres ocultar el password cuando se convierta a array o JSON
    protected $hidden = [
        'password',
    ];

    // Si 'ultimo_acceso' es un campo datetime
    protected $dates = [
        'ultimo_acceso',
    ];
}
