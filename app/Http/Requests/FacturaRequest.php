<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaRequest extends FormRequest
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
            'fecha'          => 'required|date',
            'cliente_id'     => 'required|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'total'          => 'required|numeric|min:0',
            'saldopendiente' => 'nullable|numeric|min:0',
        ];
    }
    
    public function messages(): array
    {
        return [
            'fecha.required'          => 'La fecha de la factura es obligatoria.',
            'cliente_id.required'     => 'Debe seleccionar un cliente obligatoriamente.',
            'cliente_id.exists'       => 'El cliente seleccionado no es válido.',
            'metodo_pago_id.required' => 'Debe seleccionar un método de pago.',
            'metodo_pago_id.exists'   => 'El método de pago seleccionado no existe.',
            'total.required'          => 'El total de la factura no puede estar vacío.',
            'total.numeric'           => 'El total debe ser un valor numérico.',
        ];
    }
}