<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SucursalRequest extends FormRequest
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
            'direccion' => 'required|string|max:80',
            'telefono' => 'required|string|max:50',
            'estado' => 'boolean',
        ];

        // Para actualización (PUT/PATCH), hacer los campos opcionales
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['nombre'] = 'sometimes|string|max:255';
            $rules['direccion'] = 'sometimes|string|max:80';
            $rules['telefono'] = 'sometimes|string|max:50';
            $rules['estado'] = 'sometimes|boolean';
        }

        return $rules;
    }
}
