<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacionUsuarioUpdateRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        // Permitir que la validación se ejecute (puedes personalizar según roles)
        return true;
    }

    /**
     * Reglas de validación para actualizar un usuario.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($this->route('usuario')), 
                // <-- ignora el email del usuario actual (usa el nombre del parámetro de ruta)
            ],
            'password' => ['nullable', 'string', 'min:8'], // puede dejarse vacío si no se actualiza
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'rol' => ['required', 'string', 'max:50'],
            'estado' => ['required', 'boolean'],
            'ultimo_acceso' => ['nullable', 'date'],
        ];
    }

    /**
     * Mensajes personalizados para los errores de validación.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'El correo ya está registrado por otro usuario.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',

            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'nombres.required' => 'Los nombres son obligatorios.',
            'nombres.string' => 'Los nombres deben ser texto.',
            'nombres.max' => 'Los nombres no deben exceder los 100 caracteres.',

            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.string' => 'Los apellidos deben ser texto.',
            'apellidos.max' => 'Los apellidos no deben exceder los 100 caracteres.',

            'rol.required' => 'El rol es obligatorio.',
            'rol.string' => 'El rol debe ser texto.',
            'rol.max' => 'El rol no debe exceder los 50 caracteres.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',

            'ultimo_acceso.date' => 'La fecha de último acceso debe tener un formato válido.',
        ];
    }
}
