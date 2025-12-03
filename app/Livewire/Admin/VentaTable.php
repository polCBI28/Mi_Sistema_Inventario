<?php

namespace App\Livewire\Admin;

use App\Models\Venta;
use Livewire\Component;
use Livewire\WithPagination;

class VentaTable extends Component
{
    use WithPagination;

    // Para mantener la paginación cuando se actualiza
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Obtener ventas con relación a usuario y cliente, ordenadas por fecha descendente
        $ventas = Venta::with(['usuario', 'cliente'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('livewire.admin.venta-table', compact('ventas'));
    }
}
