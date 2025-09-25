<?php

namespace App\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyValidateRequest extends FormRequest
{
    /**
     * Inclui o id do cliente logado na requisicao
     */
    protected function prepareForValidation()
    {
        $formattedData = [
            'client_id' => session('client_context', auth()->user()->person->id),
            'status' => is_null($this->cnpj) ? 4 : 1,
            'capital_social' => str_replace(',', '.', preg_replace('/[^\d,]/', '', $this->capital_social)),
        ];

        if ($this->isMethod('put')) {
            unset($formattedData['status']);
            if(!isset($this->capital_social) || $this->capital_social == null){
                unset($formattedData['capital_social']);
            }
        }
        
        $this->merge($formattedData);        
    }
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
        $mutable = [
            'area_atividade_id'    => ['integer', 'gt:0', 'exists:areas_atividade,id'],
            'bairro'               => ['string', 'max:255'],
            'capital_social'       => ['decimal:0,2', 'min:0'],
            'cep'                  => ['string', 'max:255'],
            'client_id'            => ['integer', 'gt:0', 'exists:people,id'],
            'cnae_id'              => ['array'],
            'estado'               => ['string', 'max:255'],
            'faixa_faturamento_id' => ['integer', 'gt:0', 'exists:faixas_faturamento,id'],
            'logradouro'           => ['string', 'max:255'],
            'natureza_juridica_id' => ['integer', 'gt:0', 'exists:naturezas_juridicas,id'],
            'nome_fantasia'        => ['string', 'max:255'],
            'razao_social'         => ['string', 'max:255'],
            'regime_tributario_id' => ['integer', 'gt:0', 'exists:regimes_tributarios,id'],
            'status'               => [Rule::in([0, 1, 2, 3, 4])],
        ];      
        
        $others = [            
            'cnpj'                 => ['sometimes', 'nullable', 'string', 'max:255'],
            'complemento'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'data_abertura'        => ['sometimes', 'nullable', 'date'],
            'id'                   => ['sometimes', 'nullable', 'integer', 'gt:0'],
            'inscricao_estadual'   => ['sometimes', 'nullable', 'string', 'max:255'],
            'inscricao_municipal'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'localidade'           => ['sometimes', 'nullable', 'string', 'max:255'],
            'numero'               => ['sometimes', 'nullable', 'string', 'max:255'],
            'numero_inscricao'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'tipo_inscricao'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'total_funcionarios'   => ['sometimes', 'nullable', 'integer', 'min:0'],
        ];

        if ($this->isMethod('post')) {
            foreach ($mutable as $key => $value) {
                $mutable[$key][] = 'required';
            }
        }
        
        if ($this->isMethod('put')) {
            $data = $this->all();
            foreach ($mutable as $key => $value) {
                if(in_array($key, $data)) {
                    $mutable[$key][] = 'required';
                    continue;
                }
                $mutable[$key][] = 'sometimes';
            }
            $this->request->remove('_method');
            $this->request->remove('status');
        }
        $mutable['cnae_id.*'] = ['integer', 'exists:cnae,id'];
        return array_merge($mutable, $others);
    }

    public function messages(): array
    {
        return [
            'cnae_id.required'              => 'O cnae é obrigatório.',
            'cnae_id.integer'               => 'O cnae deve ser um número inteiro.',
            'cnae_id.exists'                => 'O cnae nao existe na base de dados.',
            'faixa_faturamento_id.required' => 'A faixa de faturamento é obrigatória.',
            'faixa_faturamento_id.integer'  => 'A faixa de faturamento deve ser um número inteiro.',
            'faixa_faturamento_id.exists'   => 'A faixa de faturamento nao existe na base de dados.',
            'natureza_juridica_id.required' => 'A natureza jurídica é obrigatória.',
            'natureza_juridica_id.integer'  => 'A natureza jurídica deve ser um número inteiro.',
            'natureza_juridica_id.exists'   => 'A natureza jurídica nao existe na base de dados.',
            'area_atividade_id.required'    => 'A área de atividade é obrigatória.',
            'area_atividade_id.integer'     => 'A área de atividade deve ser um número inteiro.',
            'area_atividade_id.exists'      => 'A área de atividade nao existe na base de dados.',
            'regime_tributario_id.required' => 'O regime tributário é obrigatório.',
            'regime_tributario_id.integer'  => 'O regime tributário deve ser um número inteiro.',
            'regime_tributario_id.exists'   => 'O regime tributário nao existe na base de dados.',
            'razao_social.required'         => 'A razão social é obrigatória.',
            'razao_social.string'           => 'A razão social deve ser um texto.',
            'razao_social.max'              => 'A razão social deve ter no máximo 255 caracteres.',
            'nome_fantasia.required'        => 'O nome fantasia é obrigatório.',
            'nome_fantasia.string'          => 'O nome fantasia deve ser um texto.',
            'nome_fantasia.max'             => 'O nome fantasia deve ter no máximo 255 caracteres.',
            'cnpj.string'                   => 'O cnpj deve ser um texto.',
            'cnpj.max'                      => 'O cnpj deve ter no máximo 255 caracteres.',
            'inscricao_estadual.string'     => 'A inscrição estadual deve ser um texto.',
            'inscricao_estadual.max'        => 'A inscrição estadual deve ter no máximo 255 caracteres.',
            'inscricao_municipal.string'    => 'A inscrição municipal deve ser um texto.',
            'inscricao_municipal.max'       => 'A inscrição municipal deve ter no máximo 255 caracteres.',
            'capital_social.required'       => 'O capital social é obrigatório.',
            'capital_social.decimal'        => 'O capital social deve ser um número decimal.',
            'capital_social.min'            => 'O capital social deve ser maior ou igual a zero.',
            'logradouro.required'           => 'O logradouro é obrigatório.',
            'logradouro.string'             => 'O logradouro deve ser um texto.',
            'logradouro.max'                => 'O logradouro deve ter no.maxcdn 255 caracteres.',
            'numero.required'               => 'O numero é obrigatório.',
            'numero.string'                 => 'O numero deve ser um texto.',
            'numero.max'                    => 'O numero deve ter no.maxcdn 255 caracteres.',
            'complemento.string'            => 'O complemento deve ser um texto.',
            'complemento.max'               => 'O complemento deve ter no.maxcdn 255 caracteres.',
            'bairro.required'               => 'O bairro é obrigatório.',
            'bairro.string'                 => 'O bairro deve ser um texto.',
            'bairro.max'                    => 'O bairro deve ter no.maxcdn 255 caracteres.',
            'cep.required'                  => 'O cep é obrigatório.',
            'cep.string'                    => 'O cep deve ser um texto.',
            'cep.max'                       => 'O cep deve ter no.maxcdn 255 caracteres.',
            'cidade_id.required'            => 'A cidade é obrigatória.',
            'cidade_id.integer'             => 'A cidade deve ser um número inteiro.',
            'cidade_id.exists'              => 'A cidade nao existe na base de dados.',
            'estado.required'               => 'O estado é obrigatório.',
            'estado.string'                 => 'O estado deve ser um texto.',
            'estado.max'                    => 'O estado deve ter no.maxcdn 255 caracteres.',
            'municipio.required'            => 'O municipio é obrigatório.',
            'municipio.string'              => 'O municipio deve ser um texto.',
            'municipio.max'                 => 'O municipio deve ter no.maxcdn 255 caracteres.',
            'data_abertura.date'            => 'A data de abertura deve ser uma data.',
            'data_fechamento.date'          => 'A data de fechamento deve ser uma data.',
            'tipo_inscricao.string'         => 'O tipo de inscrição deve ser um texto.',
            'tipo_inscricao.max'            => 'O tipo de inscrição deve ter no.maxcdn 255 caracteres.',
            'numero_inscricao.string'       => 'O numero de inscrição deve ser um texto.',
            'numero_inscricao.max'          => 'O numero de inscrição deve ter no.maxcdn 255 caracteres.',
        ];
    }
}
