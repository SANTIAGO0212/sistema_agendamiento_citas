<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaRequest extends FormRequest
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
            'fecha' => 'date',
            'hora' => 'date_format:H:i',
            'estado' => 'boolean',
            'id_usuario'  => 'integer|exists:users,id',
            'id_servicio' => 'integer|exists:servicios,id',
            'id_especialista' => 'integer|exists:especialistas,id',
            'id_sucursal' => 'integer|exists:sucursales,id'
        ];
    }
}
