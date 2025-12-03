<?php

namespace App\Livewire\Admin;

use App\Models\DetalleCompra;
use App\Models\Product;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class DetalleCompraTable extends Component
{
    use WithPagination;

    public function render()
    {
        // Cargar los detalles con paginación
        $detalles = DetalleCompra::orderBy('created_at', 'desc')->paginate(10);

        // Cargar los productos para el select
        $productos = Producto::orderBy('nombre', 'asc')->get();

        return view('livewire.admin.detalle-compra-table', compact('detalles', 'productos'));
    }
}
