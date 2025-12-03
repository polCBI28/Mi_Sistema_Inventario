<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Http\Requests\ValidacionCompraRequest;
use App\Http\Requests\ValidacionCompraUpdateRequest;

class CompraController extends Controller
{
    public function index()
    {
        return view('admin.compra.index');
    }

    public function store(ValidacionCompraRequest $request)
    {
        Compra::create($request->validated());

        return redirect()->route('admin.compra.index')
            ->with('success', 'La compra fue registrada correctamente.');
    }

    public function update(ValidacionCompraUpdateRequest $request, string $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->update($request->validated());

        return redirect()->route('admin.compra.index')
            ->with('success', 'La compra fue actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        Compra::findOrFail($id)->delete();

        return redirect()->route('admin.compra.index')
            ->with('success', 'La compra fue eliminada correctamente.');
    }
}
