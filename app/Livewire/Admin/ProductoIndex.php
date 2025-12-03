<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\Proveedore;

class ProductoIndex extends Component
{
    public $categorias;
    public $proveedores;

    // Se ejecuta al cargar el componente
    public function mount()
    {
        $this->categorias = Categoria::all();
        $this->proveedores = Proveedore::all();
    }

    public function render()
    {
        return view('livewire.admin.producto-index');
    }
}
