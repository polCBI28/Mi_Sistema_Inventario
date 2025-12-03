<?php

namespace App\Livewire\Admin;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ClienteTable extends Component
{
    use WithPagination;

    public function render()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.cliente-table', compact('clientes'));
    }
}
