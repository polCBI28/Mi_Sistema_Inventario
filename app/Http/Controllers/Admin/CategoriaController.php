<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Http\Requests\ValidacionCategoriaRequest;
use App\Http\Requests\ValidacionCategoriaUpdateRequest;

class CategoriaController extends Controller
{
    /**
     * Muestra la vista principal de categorías.
     */
    public function index()
    {
        return view('admin.categoria.index');
    }

    /**
     * Guarda una nueva categoría.
     */
    public function store(ValidacionCategoriaRequest $request)
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue registrada correctamente.');
    }

    /**
     * Actualiza una categoría existente.
     */
    public function update(ValidacionCategoriaUpdateRequest $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->validated());

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue actualizada correctamente.');
    }

    /**
     * Elimina una categoría.
     */
    public function destroy(string $id)
    {
        Categoria::findOrFail($id)->delete();

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue eliminada correctamente.');
    }
}
