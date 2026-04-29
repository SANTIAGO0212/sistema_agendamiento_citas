<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:12',
            'estado' => 'boolean',
            'telefono' => 'required|string|max:255',
            'num_identificacion' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_tipo_documento' => 'integer|exists:tipo_documentos,id',
            'id_genero' => 'integer|exists:generos,id',
        ];
    }
}
