<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionMovimientoStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permite que cualquiera con acceso al controlador pueda usarlo
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'producto_id'       => ['required', 'exists:productos,id'],
            'tipo_movimiento'   => ['required', 'string', 'in:entrada,salida'],
            'cantidad'          => ['required', 'integer', 'min:1'],
            'stock_anterior'    => ['required', 'integer', 'min:0'],
            'stock_actual'      => ['required', 'integer', 'min:0'],
            'motivo'            => ['nullable', 'string', 'max:255'],
            'usuario_id'        => ['nullable', 'exists:users,id'],
            'referencia_id'     => ['nullable', 'integer'],
            'referencia_tabla'  => ['nullable', 'string', 'max:50'],
            'fecha_movimiento'  => ['required', 'date'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'producto_id.required' => 'El producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado no existe.',

            'tipo_movimiento.required' => 'El tipo de movimiento es obligatorio.',
            'tipo_movimiento.in' => 'El tipo de movimiento debe ser "entrada" o "salida".',

            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',

            'stock_anterior.required' => 'El stock anterior es obligatorio.',
            'stock_anterior.integer' => 'El stock anterior debe ser un número entero.',
            'stock_anterior.min' => 'El stock anterior no puede ser negativo.',

            'stock_actual.required' => 'El stock actual es obligatorio.',
            'stock_actual.integer' => 'El stock actual debe ser un número entero.',
            'stock_actual.min' => 'El stock actual no puede ser negativo.',

            'motivo.string' => 'El motivo debe ser un texto.',
            'motivo.max' => 'El motivo no puede exceder los 255 caracteres.',

            'usuario_id.exists' => 'El usuario seleccionado no existe.',

            'referencia_id.integer' => 'La referencia debe ser un número.',
            'referencia_tabla.string' => 'La referencia tabla debe ser texto.',
            'referencia_tabla.max' => 'La referencia tabla no puede exceder los 50 caracteres.',

            'fecha_movimiento.required' => 'La fecha del movimiento es obligatoria.',
            'fecha_movimiento.date' => 'La fecha del movimiento debe ser válida.',
        ];
    }
}
