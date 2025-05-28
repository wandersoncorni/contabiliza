<?php

namespace App\AccessControl\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\AccessControl\Models\Role;

class UserValidationRequest extends RegisterValidationRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'id_licensed' => Auth::user()->person->id_licensed ?? null,
            'id_client' => in_array('client', Auth::user()->person->roles) ? Auth::user()->person->id : ($this->id_client ?? null)
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['password'], $rules['password_confirmation']);
        $rules['role'] = ['sometimes', 'string', Rule::in(Role::select('label')->where('deleted_at', null)->get()->pluck('label')->toArray())];
        $rules['id_licensed'] = [$this->role == 'admin' ? 'nullable' : 'required', 'numeric', 'exists:licensed,id'];
        $rules['id_client'] = [$this->role == 'agent' ? 'required' : 'nullable', 'numeric', 'exists:people,id'];
        return $rules;
    }
    /**
     * Mensagens de erro padrão.
     */
    public function messages()
    {
        $messages = parent::messages();
        $messages['role.in'] = 'A permissão deve ser uma permissão existente.';
        $messages['role.required'] = 'A permissão é obrigatória.';
        $messages['role.string'] = 'A permissão deve ser um texto.';
        $messages['id_licensed.required'] = 'Informe o licenciado a ser associado ao usuário.';
        $messages['id_licensed.exists'] = 'O licendiado é invalido.';
        $messages['id_client.required'] = 'Informe o cliente a ser associado ao agente.';
        $messages['id_client.exists'] = 'O cliente é invalido.';
        return $messages;
    }
}
