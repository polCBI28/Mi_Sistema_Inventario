<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\ValidacionClienteRequest;
use App\Http\Requests\ValidacionClienteUpdateRequest;

class ClienteController extends Controller
{
    public function index()
    {
        return view('admin.cliente.index');
    }

    public function store(ValidacionClienteRequest $request)
    {
        Cliente::create($request->validated());

        return redirect()->route('admin.cliente.index')
            ->with('success', 'El cliente fue registrado correctamente.');
    }

    public function update(ValidacionClienteUpdateRequest $request, string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->validated());

        return redirect()->route('admin.cliente.index')
            ->with('success', 'El cliente fue actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Cliente::findOrFail($id)->delete();

        return redirect()->route('admin.cliente.index')
            ->with('success', 'El cliente fue eliminado correctamente.');
    }
}
