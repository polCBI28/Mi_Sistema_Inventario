<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'proveedor_id',
        'nombre',
        'descripcion',
        'codigo_barra',
        'precio_venta',
        'precio_compra',
        'stock',
        'stock_minimo',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }
}
