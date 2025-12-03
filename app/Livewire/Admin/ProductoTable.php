<?php

namespace App\Livewire\Admin;

use App\Models\Producto;
use App\Models\Categoria; // <--- importar el modelo de categorías
use Livewire\Component;
use Livewire\WithPagination;

class ProductoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);
        $categorias = Categoria::all(); // <--- obtenemos todas las categorías

        return view('livewire.admin.producto-table', compact('productos', 'categorias'));
    }
}
