<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'total',
        'usuario_id',
        'proveedor_id',
        'tipo_comprobante',
        'numero_comprobante',
        'igv',
        'subtotal',
        'estado',
        'observaciones'
    ];
}
