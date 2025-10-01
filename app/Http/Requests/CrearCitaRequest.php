<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearCitaRequest extends FormRequest
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
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'estado' => 'boolean',
            'id_usuario'  => 'required|integer|exists:users,id',
            'id_servicio' => 'required|integer|exists:servicios,id',
            'id_especialista' => 'required|integer|exists:especialistas,id',
            'id_sucursal' => 'required|integer|exists:sucursales,id'
        ];
    }
}
