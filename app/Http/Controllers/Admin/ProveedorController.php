<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionProveedorRequest;
use App\Http\Requests\ValidacionProveedorUpdateRequest;
use App\Models\Proveedore;

class ProveedorController extends Controller
{
    /**
     * Mostrar la lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedore::orderBy('id', 'desc')->paginate(10);
        return view('admin.proveedor.index', compact('proveedores'));
    }

    /**
     * Guardar un nuevo proveedor.
     */
    public function store(ValidacionProveedorRequest $request)
    {
        Proveedore::create($request->validated());

        return redirect()->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue registrado correctamente.');
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(ValidacionProveedorUpdateRequest $request, string $id)
    {
        $proveedor = Proveedore::findOrFail($id);
        $proveedor->update($request->validated());

        return redirect()->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue actualizado correctamente.');
    }

    /**
     * Eliminar un proveedor.
     */
    public function destroy(string $id)
    {
        Proveedore::findOrFail($id)->delete();

        return redirect()->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue eliminado correctamente.');
    }
}
