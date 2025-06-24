<?php

namespace App\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyValidateRequest extends FormRequest
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
            'id'            => ['integer', 'gt:0'],
            'name'          => ['required', 'string', 'max:255'],
            'razao_social'  => ['required', 'string', 'max:255'],
            'cnae'          => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
