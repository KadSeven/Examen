<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetodoPagoRequest extends FormRequest
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
            'tipo' => 'required|string|max:255|unique:metodo_pagos,tipo,' . $this->route('metodo_pago'),
        ];
    }
    public function messages(): array
    {
        return [
            'tipo.required' => 'El nombre del método de pago es obligatorio.',
            'tipo.string'   => 'El método de pago debe ser un texto válido.',
            'tipo.max'      => 'El nombre es demasiado largo (máximo 255 caracteres).',
            'tipo.unique'   => 'Este método de pago ya se encuentra registrado en el sistema.',
        ];
    }
}
