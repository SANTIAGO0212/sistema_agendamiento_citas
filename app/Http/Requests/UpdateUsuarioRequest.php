<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
            'name' => 'string',
            'email' => 'string|email|unique:users,email,' . $this->route('id'),
            'password' => 'string|max:12',
            'estado' => 'boolean',
            'telefono' => 'string|max:255',
            'num_identificacion' => 'string|max:255',
            'direccion' => 'string|max:255',
            'id_tipo_documento' => 'exists:tipo_documentos,id',
            'id_genero' => 'exists:generos,id',
        ];
    }
}
