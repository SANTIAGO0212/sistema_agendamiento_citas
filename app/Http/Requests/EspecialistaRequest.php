<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EspecialistaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'email'  => 'required|string|email|max:255',
            'estado' => 'default:1',
            'id_sucursal' => 'required|integer|exists:sucursales,id',
            'id_servicio' => 'required|integer|exists:servicios,id'
        ];
    }
}
