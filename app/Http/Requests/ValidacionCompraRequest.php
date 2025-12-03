<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionCompraRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado.
     */
    public function authorize(): bool
    {
        return true; // Igual que el profesor
    }

    /**
     * Reglas de validación para registrar una compra.
     */
    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
            'usuario_id' => ['required', 'integer'],
            'proveedor_id' => ['required', 'integer'],
            'tipo_comprobante' => ['required', 'string', 'max:50'],
            'numero_comprobante' => ['required', 'string', 'max:50'],
            'igv' => ['required', 'numeric', 'min:0'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'string', 'max:20'],
            'observaciones' => ['nullable', 'string'],
        ];
    }

    /**
     * Mensajes personalizados para errores.
     */
    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'Debe ingresar una fecha válida.',

            'total.required' => 'El total es obligatorio.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser negativo.',

            'usuario_id.required' => 'El usuario es obligatorio.',
            'usuario_id.integer' => 'El usuario debe ser un ID válido.',

            'proveedor_id.required' => 'El proveedor es obligatorio.',
            'proveedor_id.integer' => 'El proveedor debe ser un ID válido.',

            'tipo_comprobante.required' => 'El tipo de comprobante es obligatorio.',
            'tipo_comprobante.string' => 'El tipo de comprobante debe ser texto.',
            'tipo_comprobante.max' => 'El tipo de comprobante no debe pasar 50 caracteres.',

            'numero_comprobante.required' => 'El número de comprobante es obligatorio.',
            'numero_comprobante.string' => 'El número de comprobante debe ser texto.',
            'numero_comprobante.max' => 'El número de comprobante no debe pasar 50 caracteres.',

            'igv.required' => 'El IGV es obligatorio.',
            'igv.numeric' => 'El IGV debe ser numérico.',
            'igv.min' => 'El IGV no puede ser negativo.',

            'subtotal.required' => 'El subtotal es obligatorio.',
            'subtotal.numeric' => 'El subtotal debe ser un número.',
            'subtotal.min' => 'El subtotal no puede ser negativo.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.string' => 'El estado debe ser texto.',
            'estado.max' => 'El estado no debe pasar 20 caracteres.',

            'observaciones.string' => 'Las observaciones deben ser texto.',
        ];
    }
}
