<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionClienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado.
     */
    public function authorize(): bool
    {
        return true; // igual que el profesor, permitir acceso
    }

    /**
     * Reglas de validación para registrar o actualizar un cliente.
     */
    public function rules(): array
    {
        return [
            'tipo_documento'     => ['required', 'string', 'max:20'],
            'numero_documento'   => ['required', 'string', 'max:20'],
            'nombres'            => ['required', 'string', 'max:120'],
            'apellidos'          => ['required', 'string', 'max:120'],
            'email'              => ['nullable', 'email', 'max:120'],
            'telefono'           => ['nullable', 'string', 'max:20'],
            'direccion'          => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento'   => ['nullable', 'date'],
            'estado'             => ['required', 'boolean'],
        ];
    }

    /**
     * Mensajes personalizados para los errores.
     */
    public function messages(): array
    {
        return [
            'tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento.string'   => 'El tipo de documento debe ser texto.',
            'tipo_documento.max'      => 'El tipo de documento no debe exceder los 20 caracteres.',

            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.string'   => 'El número de documento debe ser texto.',
            'numero_documento.max'      => 'El número de documento no debe exceder los 20 caracteres.',

            'nombres.required' => 'Los nombres son obligatorios.',
            'nombres.string'   => 'El nombre debe ser texto.',
            'nombres.max'      => 'Los nombres no deben exceder los 120 caracteres.',

            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.string'   => 'Los apellidos deben ser texto.',
            'apellidos.max'      => 'Los apellidos no deben exceder los 120 caracteres.',

            'email.email' => 'El correo debe ser válido.',
            'email.max'   => 'El correo no debe exceder los 120 caracteres.',

            'telefono.string' => 'El teléfono debe ser texto.',
            'telefono.max'    => 'El teléfono no debe exceder los 20 caracteres.',

            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max'    => 'La dirección no debe exceder los 255 caracteres.',

            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.boolean'  => 'El estado debe ser verdadero o falso.',
        ];
    }
}
