<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Venta;

class VentaIndex extends Component
{
    public $usuarios;
    public $clientes;
    public $ventas;

    public function mount()
    {
        // Cargar datos al iniciar el componente
        $this->usuarios = User::all();
        $this->clientes = Cliente::all();
        $this->ventas = Venta::with(['usuario', 'cliente'])->get();
    }

    public function render()
    {
        return view('livewire.admin.venta-index');
    }
}
