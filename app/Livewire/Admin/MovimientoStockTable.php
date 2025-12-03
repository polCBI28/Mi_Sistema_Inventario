<?php

namespace App\Livewire\Admin;

use App\Models\MovimientoStock;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class MovimientoStockTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $productos; // Lista de productos

    public $producto_id;
    public $tipo_movimiento;
    public $cantidad;
    public $stock_anterior;
    public $stock_actual;
    public $motivo;
    public $movimiento_id;

    public $isOpen = false; // Controla el modal

    public function mount()
    {
        $this->productos = Producto::orderBy('nombre')->get();
    }

    public function render()
    {
        $movimientos = MovimientoStock::with(['producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->paginate(10);

        return view('livewire.admin.movimiento-stock-table', compact('movimientos'));
    }

    // Abrir modal y cargar datos
    public function openModal(MovimientoStock $movimiento)
    {
        $this->movimiento_id = $movimiento->id;
        $this->producto_id = $movimiento->producto_id;
        $this->tipo_movimiento = $movimiento->tipo_movimiento;
        $this->cantidad = $movimiento->cantidad;
        $this->stock_anterior = $movimiento->stock_anterior;
        $this->stock_actual = $movimiento->stock_actual;
        $this->motivo = $movimiento->motivo;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['movimiento_id', 'producto_id', 'tipo_movimiento', 'cantidad', 'stock_anterior', 'stock_actual', 'motivo', 'isOpen']);
    }
}
