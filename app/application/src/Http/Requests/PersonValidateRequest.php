<?php

namespace App\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonValidateRequest extends FormRequest
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
            'id_user'    => ['required', 'integer', 'exists:users,id'],
            'name'       => ['sometimes', 'string', 'max:255'],
            'phone'      => ['sometimes', 'string', 'regex:/^\+?[0-9\s\-]{8,15}$/'],
            'roles'      => ['required', 'array'],
            'roles.*'    => ['string'], // Cada item do array deve ser string
            'created_at' => ['nullable', 'date'],
            'updated_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'O ID do usuário é obrigatório.',
            'id_user.integer'  => 'O ID do usuário deve ser um número inteiro.',
            'id_user.exists'   => 'O ID do usuário não existe na base de dados.',
            'name.required'    => 'O nome é obrigatório.',
            'name.string'      => 'O nome deve ser um texto.',
            'name.max'         => 'O nome deve ter no máximo 255 caracteres.',
            'phone.regex'      => 'O telefone deve estar em um formato válido.',
            'roles.required'   => 'Pelo menos um papel (role) deve ser informado.',
            'roles.array'      => 'Os papéis devem ser enviados como uma lista.',
            'roles.*.string'   => 'Cada papel deve ser um texto.',
            'created_at.date'  => 'A data de criação deve ser uma data válida.',
            'updated_at.date'  => 'A data de atualização deve ser uma data válida.',
        ];
    }
}
