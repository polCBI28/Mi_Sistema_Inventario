<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Http\Requests\ValidacionVentaRequest;
use App\Http\Requests\ValidationVentaUpdateRequest;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Validation\ValidationException;

class VentaController extends Controller
{
    /**
     * Listar todas las ventas
     */
    public function index()
    {
        $ventas = Venta::with(['usuario', 'cliente'])->get();
        $usuarios = Usuario::all();        // Trae todos los usuarios
        $clientes = Cliente::all();     // Trae todos los clientes

        return view('admin.venta.index', compact('ventas', 'usuarios', 'clientes'));
    }

    /**
     * Registrar una nueva venta
     */
    public function store(ValidacionVentaRequest $request)
    {
        try {
            $data = $request->validated();
            Venta::create($data);

            return redirect()->route('admin.venta.index')
                ->with('success', 'La venta fue registrada correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Actualizar una venta existente
     */
    public function update(ValidationVentaUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $venta = Venta::findOrFail($id);
            $venta->update($data);

            return redirect()->route('admin.venta.index')
                ->with('success', 'La venta fue actualizada correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Eliminar una venta
     */
    public function destroy(string $id)
    {
        Venta::findOrFail($id)->delete();
        return redirect()->route('admin.venta.index')
            ->with('success', 'La venta fue eliminada correctamente.');
    }
}
