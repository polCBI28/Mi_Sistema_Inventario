<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovimientoStock;
use App\Http\Requests\ValidacionMovimientoStockRequest;
use App\Http\Requests\ValidacionMovimientoStockUpdateRequest;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth; // <-- Importante

class MovimientoStockController extends Controller
{
    // Listar todos los movimientos
    public function index()
    {
        $movimientos = MovimientoStock::with(['producto', 'usuario'])->get();
        $productos = Producto::orderBy('nombre')->get(); // Traer productos
        return view('admin.movimientostock.index', compact('movimientos', 'productos'));
    }

    // Registrar un nuevo movimiento
    public function store(ValidacionMovimientoStockRequest $request)
    {
        // Tomamos los datos validados
        $data = $request->validated();

        // Asignamos el usuario logueado automáticamente
        $data['usuario_id'] = Auth::id(); // <-- Ahora funciona correctamente

        // Creamos el registro en la base de datos
        MovimientoStock::create($data);

        return redirect()->route('admin.movimiento_stock.index')
            ->with('success', 'El movimiento fue registrado correctamente.');
    }

    // Actualizar un movimiento existente
    public function update(ValidacionMovimientoStockUpdateRequest $request, string $id)
    {
        $movimiento = MovimientoStock::findOrFail($id);
        $movimiento->update($request->validated());

        return redirect()->route('admin.movimiento_stock.index')
            ->with('success', 'El movimiento fue actualizado correctamente.');
    }

    // Eliminar un movimiento
    public function destroy(string $id)
    {
        $movimiento = MovimientoStock::findOrFail($id);
        $movimiento->delete();

        return redirect()->route('admin.movimiento_stock.index')
            ->with('success', 'El movimiento fue eliminado correctamente.');
    }
}
