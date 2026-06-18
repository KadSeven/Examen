<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'        => 'required|string|max:255',
            'precio_venta'  => 'required|numeric|min:0',
            'descripcion'   => 'nullable|string|max:1000',
            'stock'         => 'required|integer|min:0',
            'stock_minimo'  => 'required|integer|min:0',
            'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Valida que sea foto real de max 2MB
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre del producto es obligatorio.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.numeric'  => 'El precio debe ser un número válido.',
            'precio_venta.min'      => 'El precio de venta no puede ser menor a cero.',
            'stock.required'        => 'Debes ingresar el stock inicial.',
            'stock.integer'         => 'El stock debe ser un número entero.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio para las alertas.',
            'imagen.image'          => 'El archivo seleccionado debe ser una imagen.',
            'imagen.mimes'          => 'La imagen debe ser de formato: jpeg, png, jpg o svg.',
            'imagen.max'            => 'La imagen no debe pesar más de 2MB.',
        ];
    }

}
