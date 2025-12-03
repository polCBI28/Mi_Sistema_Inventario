<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionProveedorUpdateRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar un proveedor.
     */
    public function rules(): array
    {
        // Obtenemos el ID del proveedor de la ruta
        $proveedorId = $this->route('proveedor'); // Asegúrate de que coincida con el parámetro de tu ruta

        return [
            'ruc' => 'required|max:20|unique:proveedores,ruc,' . $proveedorId,
            'razon_social' => 'required|max:150',
            'direccion' => 'nullable|max:200',
            'telefono' => 'nullable|max:20',
            'email' => 'nullable|email|max:100|unique:proveedores,email,' . $proveedorId,
            'estado' => 'required|boolean',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'ruc.required' => 'El RUC es obligatorio.',
            'ruc.unique' => 'Este RUC ya está registrado.',
            'ruc.max' => 'El RUC no puede tener más de 20 caracteres.',

            'razon_social.required' => 'La razón social es obligatoria.',
            'razon_social.max' => 'La razón social no puede tener más de 150 caracteres.',

            'direccion.max' => 'La dirección no puede tener más de 200 caracteres.',

            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',

            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
