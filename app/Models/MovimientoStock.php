<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoStock extends Model
{
    protected $table = 'movimientos_stock';

    protected $fillable = [
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'stock_anterior',
        'stock_actual',
        'motivo',
        'usuario_id',
        'referencia_id',
        'referencia_tabla',
        'fecha_movimiento',
    ];

    public $timestamps = false;

    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'stock_anterior'   => 'integer',
        'stock_actual'     => 'integer',
        'cantidad'         => 'integer',
    ];

    /** 
     * Relación con Producto (muchos → uno)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación con Usuario (muchos → uno)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación dinámica con la tabla referenciada (compra o venta)
     */
    public function referencia()
    {
        return $this->morphTo(null, 'referencia_tabla', 'referencia_id');
    }
}
