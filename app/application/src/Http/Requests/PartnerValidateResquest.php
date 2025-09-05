<?php

namespace App\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerValidateResquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [
            'client_id' => session('client_context', auth()->user()->person->id),
            //'regime_bens' => $this->estado_civil == 2 ? $this->regime_bens : null
        ];
        
        if($this->participacao){
            $data['participacao'] = preg_replace('/[^0-9.]/', '', $this->participacao);
        }
        
        // Ensure the 'id' field is always an integer, even if not present
        $this->merge($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $default = [
            'id' => ['nullable','integer','exists:socios,id'],  
            'client_id' => ['required', 'integer', 'exists:people,id']
        ];
        $required = [            
            'nome' => ['string','max:255'],
            'cpf' => ['required','string', new \App\Rules\Cpf()],
            'empresa_id' => ['integer','exists:empresas,id'],
            'estado_civil' => ['integer','exists:estados_civis,id'],
            'profissao' => ['string','max:255'],
            'participacao' => ['numeric','min:0','max:100'],
            'logradouro' => ['string','max:255'],
            'localidade' => ['string','max:255'],
            'bairro' => ['string','max:255'],
            'cep' => ['string','max:255'],
            'estado' => ['string','max:2'],
        ];
        $notRequired = [          
            'pro_labore' => ['boolean'],
            'numero' => ['string','max:50'],
            'complemento' => ['string','max:255'],
            'regime_bens' => ['numeric','exists:regimes_bens,id','required_if:estado_civil,2','in:1,2,3,4,5'],
            'resp_rf' => ['boolean'],
        ];

        if($this->isMethod('post')) {
            foreach ($required as $key => $value) {
                $required[$key][] = 'required';
            }

            foreach ($notRequired as $key => $value) {
                $notRequired[$key][] = 'nullable';
            }
        }
        else if($this->isMethod('put')) {
            foreach ($required as $key => $value) {
                $required[$key][] = 'sometimes';
            }
            foreach ($notRequired as $key => $value) {
                $notRequired[$key][] = 'sometimes';
            }
            $this->request->remove('_method');
            unset($required['company_id']);
        }

        return array_merge($default,$required, $notRequired);
    }

    public function messages(): array
    {
        return [
            'id_empresa.required' => 'O campo Empresa é obrigatório.',
            'nome.required' => 'O campo Nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.cpf' => 'O CPF informado é inválido.',
            'cpf.string' => 'O campo CPF deve ser uma string.',
            'estado_civil.required' => 'O campo Estado Civil é obrigatório.',
            'profissao.required' => 'O campo Profissão é obrigatório.',
            'participacao.required' => 'O campo Participação é obrigatório.',
            'pro_labore.required' => 'O campo Pró-Labore é obrigatório.',
            'pro_labore.numeric' => 'O campo Pró-Labore deve ser um número.',
            'participacao.numeric' => 'O campo Participação deve ser um número.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'regime_bens.required' => 'O campo Regime de Bens é obrigatório quando o Estado Civil for Casado.',
            'regime_bens.in' => 'O campo Regime de Bens deve ser uma das opções da lista.',
            'regime_bens.required_if' => 'O campo Regime de Bens é obrigatório quando o Estado Civil for Casado.',
        ];
    }
}
