<?php

namespace App\Livewire\Admin;

use App\Models\Proveedore;
use Livewire\Component;
use Livewire\WithPagination;

class ProveedorTable extends Component
{
    use WithPagination;

    public function render()
    {
        // Obtenemos los proveedores ordenados por fecha de creación (más recientes primero)
        $proveedores = Proveedore::orderBy('created_at', 'desc')->paginate(10);

        // Retornamos la vista Livewire con los datos
        return view('livewire.admin.proveedor-table', compact('proveedores'));
    }
}
