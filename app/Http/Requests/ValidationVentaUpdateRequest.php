<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationVentaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitimos que se pueda usar el request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'], // Fecha de la venta
            'total' => ['required', 'numeric', 'min:0'],
            'usuario_id' => ['required', 'exists:users,id'], // ID del usuario
            'cliente_id' => ['required', 'exists:clientes,id'], // ID del cliente
            'tipo_comprobante' => ['required', 'string', 'max:50'],
            'numero_comprobante' => ['required', 'string', 'max:100'],
            'igv' => ['required', 'numeric', 'min:0'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'descuento' => ['nullable', 'numeric', 'min:0'],
            'estado' => ['required', 'string', 'max:20'],
            'metodo_pago' => ['required', 'string', 'max:50'],
            'observaciones' => ['nullable', 'string'],
        ];
    }

    /**
     * Mensajes personalizados para los errores.
     */
    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe tener un formato válido.',

            'total.required' => 'El total es obligatorio.',
            'total.numeric' => 'El total debe ser un número.',
            'total.min' => 'El total no puede ser negativo.',

            'usuario_id.required' => 'El usuario es obligatorio.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.',

            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',

            'tipo_comprobante.required' => 'El tipo de comprobante es obligatorio.',
            'tipo_comprobante.string' => 'El tipo de comprobante debe ser texto.',

            'numero_comprobante.required' => 'El número de comprobante es obligatorio.',
            'numero_comprobante.string' => 'El número de comprobante debe ser texto.',

            'igv.required' => 'El IGV es obligatorio.',
            'igv.numeric' => 'El IGV debe ser un número.',
            'igv.min' => 'El IGV no puede ser negativo.',

            'subtotal.required' => 'El subtotal es obligatorio.',
            'subtotal.numeric' => 'El subtotal debe ser un número.',
            'subtotal.min' => 'El subtotal no puede ser negativo.',

            'descuento.numeric' => 'El descuento debe ser un número.',
            'descuento.min' => 'El descuento no puede ser negativo.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.string' => 'El estado debe ser texto.',

            'metodo_pago.required' => 'El método de pago es obligatorio.',
            'metodo_pago.string' => 'El método de pago debe ser texto.',

            'observaciones.string' => 'Las observaciones deben ser texto.',
        ];
    }
}
