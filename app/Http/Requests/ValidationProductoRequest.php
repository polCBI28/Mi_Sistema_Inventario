<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationProductoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación que se aplican al crear un producto.
     */
    public function rules(): array
    {
        return [
            'categoria_id'   => 'required|exists:categorias,id',
            'proveedor_id'   => 'required|exists:proveedores,id',
            'nombre'         => 'required|string|max:255|unique:productos,nombre',
            'descripcion'    => 'nullable|string|max:1000',
            'codigo_barra'   => 'nullable|string|max:100|unique:productos,codigo_barra',
            'precio_venta'   => 'required|numeric|min:0',
            'precio_compra'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'stock_minimo'   => 'required|integer|min:0',
            'estado'         => 'required|boolean',
        ];
    }

    /**
     * Mensajes personalizados para los errores de validación.
     */
    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
            'proveedor_id.required' => 'Debe seleccionar un proveedor.',
            'proveedor_id.exists'   => 'El proveedor seleccionado no es válido.',
            'nombre.required'       => 'El nombre del producto es obligatorio.',
            'nombre.unique'         => 'Ya existe un producto con ese nombre.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.numeric'  => 'El precio de venta debe ser numérico.',
            'precio_compra.required'=> 'El precio de compra es obligatorio.',
            'stock.required'        => 'El stock es obligatorio.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'estado.required'       => 'Debe especificar el estado del producto.',
        ];
    }
}
