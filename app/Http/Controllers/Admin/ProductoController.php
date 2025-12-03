<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\ValidationProductoRequest;
use App\Http\Requests\ValidationProductoUpdateRequest;
use App\Models\Proveedore;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos y el formulario de registro.
     */
    public function index()
    {
        $categorias = Categoria::all();      // Todas las categorías
        $proveedores = Proveedore::all();     // Todos los proveedores

        return view('admin.producto.index', compact('categorias', 'proveedores'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(ValidationProductoRequest $request)
    {
        Producto::create($request->validated());

        return redirect()
            ->route('admin.producto.index')
            ->with('success', 'El producto fue registrado correctamente.');
    }

    /**
     * Actualiza la información de un producto existente.
     */
    public function update(ValidationProductoUpdateRequest $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->validated());

        return redirect()
            ->route('admin.producto.index')
            ->with('success', 'El producto fue actualizado correctamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()
            ->route('admin.producto.index')
            ->with('success', 'El producto fue eliminado correctamente.');
    }
}
