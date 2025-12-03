<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    // Tabla asociada (opcional si sigue la convención)
    protected $table = 'ventas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'fecha',
        'total',
        'usuario_id',
        'cliente_id',
        'tipo_comprobante',
        'numero_comprobante',
        'igv',
        'subtotal',
        'descuento',
        'estado',
        'metodo_pago',
        'observaciones',
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
