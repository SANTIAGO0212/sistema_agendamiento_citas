<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEspecialistaRequest extends FormRequest
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
            'nombre' => 'string|max:255',
            'apellido' => 'string|max:255',
            'telefono' => 'string|max:50',
            'email'  => 'string|email|max:255',
            'estado' => 'boolean',
            'id_sucursal' => 'integer|exists:sucursales,id',
            'id_servicio' => 'integer|exists:servicios,id'
        ];
    }
}
