<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Http\Requests\ValidacionCategoriaRequest;
use App\Http\Requests\ValidacionCategoriaUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    /**
     * Muestra el listado de categorías (vista principal).
     */
    public function index(): View
    {
        // La vista se encargará de cargar las categorías mediante Livewire, API o DataTables
        return view('admin.categoria.index');
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create(): View
    {
        return view('admin.categoria.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     */
    public function store(ValidacionCategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue registrada correctamente.');
    }

    /**
     * Muestra los detalles de una categoría específica.
     */
    public function show(string $id): View
    {
        $categoria = Categoria::findOrFail($id);

        return view('admin.categoria.show', compact('categoria'));
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     */
    public function edit(string $id): View
    {
        $categoria = Categoria::findOrFail($id);

        return view('admin.categoria.edit', compact('categoria'));
    }

    /**
     * Actualiza los datos de una categoría existente.
     */
    public function update(ValidacionCategoriaUpdateRequest $request, string $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->validated());

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue actualizada correctamente.');
    }

    /**
     * Elimina una categoría de forma lógica o física.
     */
    public function destroy(string $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()
            ->route('admin.categoria.index')
            ->with('success', 'La categoría fue eliminada correctamente.');
    }
}