<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MovimientoStock;
use App\Models\Producto;

class MovimientoStockIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $productos; // Variable para la lista de productos

    public function mount()
    {
        $this->productos = Producto::orderBy('nombre')->get(); // Traemos todos los productos
    }

    public function render()
    {
        $movimientos = MovimientoStock::with(['producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->paginate(10);

        return view('livewire.admin.movimiento-stock-index', [
            'movimientos' => $movimientos,
            'productos' => $this->productos, // <-- Importante
        ]);
    }
}
