<?php

namespace App\Livewire\Admin;

use App\Models\Usuario; // 👈 usa el modelo correcto
use Livewire\Component;
use Livewire\WithPagination;

class UsuarioTable extends Component
{
    use WithPagination;

    public function render()
    {
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.usuario-table', compact('usuarios'));
    }
}
