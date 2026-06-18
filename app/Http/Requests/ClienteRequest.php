<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nombre'    => 'required|string|max:255',
            // Valida que el documento sea único en la tabla 'clientes', pero ignora al cliente actual si es una edición
            'documento' => 'required|string|max:20|unique:clientes,documento,' . $this->route('cliente'),
            'direccion' => 'nullable|string|max:255',
            'telefono'  => 'nullable|string|max:20',
            'correo'    => 'nullable|email|max:255', // Cambiado a 'correo' para que coincida con tu $fillable
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required'    => 'El nombre del cliente es obligatorio.',
            'documento.required' => 'El número de documento o cédula es obligatorio.',
            'documento.unique'   => 'Este número de documento ya se encuentra registrado.',
            'correo.email'       => 'El formato del correo electrónico no es válido.',
        ];
    }
}
