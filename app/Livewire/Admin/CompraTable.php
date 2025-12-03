<?php

namespace App\Livewire\Admin;

use App\Models\Compra;
use Livewire\Component;
use Livewire\WithPagination;

class CompraTable extends Component
{
    use WithPagination;

    public function render()
    {
        $compras = Compra::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.compra-table', compact('compras'));
    }
}
