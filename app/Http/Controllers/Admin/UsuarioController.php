<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Http\Requests\ValidacionUsuarioRequest;
use App\Http\Requests\ValidacionUsuarioUpdateRequest;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        return view('admin.usuario.index');
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(ValidacionUsuarioRequest $request)
    {
        // Cifrar la contraseña antes de guardar
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        Usuario::create($data);

        return redirect()->route('admin.usuario.index')
            ->with('success', 'El usuario fue registrado correctamente.');
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(ValidacionUsuarioUpdateRequest $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validated();

        // Si no se envía contraseña, se mantiene la actual
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuario.index')
            ->with('success', 'El usuario fue actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(string $id)
    {
        Usuario::findOrFail($id)->delete();

        return redirect()->route('admin.usuario.index')
            ->with('success', 'El usuario fue eliminado correctamente.');
    }
}
