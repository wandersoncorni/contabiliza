<?php

namespace App\AccessControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\AccessControl\Models\Role;
use Illuminate\Support\Facades\Auth;

class RegisterValidationRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8', //comprimento mínimo
                'confirmed', // campo de confirmação
                'regex:/[A-Z]/',  // pelo menos uma letra maiúscula
                'regex:/[a-z]/',  // pelo menos uma letra minúscula
                'regex:/\d/',     // pelo menos um número
                'regex:/[\W_]/',  // pelo menos um caractere especial
            ],
            'password_confirmation' => [
                'required',
                'string',
                'same:password'
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ]
        ];
    }
    /**
     * Mensagens de erro padrão.
     */
    public function messages()
    {
        return [
            'email.required' => 'O email é obrigatório.',
            'email.string' => 'O email deve conter somente caracteres padrões.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.max' => 'O email deve ter no máximo 255 caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.',
            'password.confirmed' => 'A confirmação de senha não confere.',
            'password_confirmation.required' => 'A confirmação de senha é obrigatória.',
            'password_confirmation.same' => 'A confirmação de senha não confere.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve conter somente caracteres padrões.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
        ];
    }
}
