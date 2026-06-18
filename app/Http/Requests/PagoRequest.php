<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagoRequest extends FormRequest
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
            'factura_id'     => 'required|exists:facturas,id',
            'monto'          => 'required|numeric|min:1',
            'fecha_pago'     => 'required|date',
            'metodo_pago_id' => [
                'required',
                // Asegura que el método de pago exista y esté activo (estado = 1)
                Rule::exists('metodo_pagos', 'id')->where(function ($query) {
                    $query->where('estado', '1');
                }),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'factura_id.required'     => 'Debe seleccionar una factura obligatoriamente.',
            'factura_id.exists'       => 'La factura seleccionada no es válida.',
            'monto.required'          => 'El monto del pago es obligatorio.',
            'monto.numeric'           => 'El monto debe ser un valor numérico.',
            'monto.min'               => 'El monto a pagar debe ser mínimo de 1.',
            'fecha_pago.required'     => 'La fecha en la que se realizó el pago es obligatoria.',
            'fecha_pago.date'         => 'El formato de la fecha no es válido.',
            'metodo_pago_id.required' => 'Debe elegir el método con el que se pagó.',
            'metodo_pago_id.exists'   => 'El método de pago seleccionado no se encuentra disponible.',
        ];
}
}