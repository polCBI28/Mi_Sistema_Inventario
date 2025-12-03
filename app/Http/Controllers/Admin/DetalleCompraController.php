<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetalleCompra;
use App\Http\Requests\ValidacionDetalleCompraRequest;
use App\Http\Requests\ValidacionDetalleCompraUpdateRequest;

class DetalleCompraController extends Controller
{
    /**
     * Vista principal
     */
    public function index()
    {
        return view('admin.detallecompra.index');
    }

    /**
     * Registrar un detalle de compra
     */
    public function store(ValidacionDetalleCompraRequest $request)
    {
        DetalleCompra::create([
            'compra_id' => $request->compra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $request->cantidad * $request->precio_unitario,
        ]);

        return redirect()->route('admin.detallecompra.index')
            ->with('success', 'El detalle de compra fue registrado correctamente.');
    }

    /**
     * Actualizar un detalle de compra
     */
    public function update(ValidacionDetalleCompraUpdateRequest $request, string $id)
    {
        $detalle = DetalleCompra::findOrFail($id);

        $detalle->update([
            'compra_id' => $request->compra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $request->cantidad * $request->precio_unitario
        ]);

        return redirect()->route('admin.detallecompra.index')
            ->with('success', 'El detalle de compra fue actualizado correctamente.');
    }

    /**
     * Eliminar un detalle
     */
    public function destroy(string $id)
    {
        DetalleCompra::findOrFail($id)->delete();

        return redirect()->route('admin.detallecompra.index')
            ->with('success', 'El detalle de compra fue eliminado correctamente.');
    }
}
