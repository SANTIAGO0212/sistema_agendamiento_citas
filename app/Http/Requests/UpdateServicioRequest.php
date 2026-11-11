<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicioRequest extends FormRequest
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
            'descripcion' => 'string|max:255',
            'valor_inicial' => 'decimal:0,2',
            'descuento' => 'boolean',
            'valor_descuento' => 'decimal:0,2',
            'valor_total' => 'decimal:0,2',
            'estado' => 'boolean',
        ];
    }
}
