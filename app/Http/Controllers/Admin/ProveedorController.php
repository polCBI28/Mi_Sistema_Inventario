<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidacionProveedorRequest;
use App\Http\Requests\ValidacionProveedorUpdateRequest;
use App\Models\Proveedore;
use Illuminate\Http\RedirectResponse;

class ProveedorController extends Controller
{
    /**
     * Mostrar el listado paginado de proveedores.
     */
    public function index(): \Illuminate\View\View
    {
        $proveedores = Proveedore::latest()->paginate(10);

        return view('admin.proveedor.index', compact('proveedores'));
    }

    /**
     * Crear un nuevo proveedor.
     */
    public function store(ValidacionProveedorRequest $request): RedirectResponse
    {
        Proveedore::create($request->validated());

        return redirect()
            ->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue registrado correctamente.');
    }

    /**
     * Actualizar un proveedor existente.
     */
    public function update(ValidacionProveedorUpdateRequest $request, int $id): RedirectResponse
    {
        $proveedor = Proveedore::findOrFail($id);
        $proveedor->update($request->validated());

        return redirect()
            ->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue actualizado correctamente.');
    }

    /**
     * Eliminar un proveedor.
     */
    public function destroy(int $id): RedirectResponse
    {
        Proveedore::findOrFail($id)->delete();

        return redirect()
            ->route('admin.proveedor.index')
            ->with('success', 'El proveedor fue eliminado correctamente.');
    }
}