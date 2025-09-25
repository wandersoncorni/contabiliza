<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\CompanyValidateRequest;
use App\Application\Models\Empresa;
use App\Application\Models\EmpresaCnae;
use App\Application\Models\PlanoServicoContratado;
use App\Application\Models\PlanoServico;
use App\Application\Models\TiposPagamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Company
{
    public function list(): JsonResponse
    {
        return response()->json(Empresa::with('cnae')->get());
    }
    /**
     * Metodo para criar uma empresa na aplicação. É uma empresa existente
     * com dados cadastrados nos órgãos competentes
     */
    public function create(CompanyValidateRequest $request): JsonResponse
    {
        $data = $request->all();

        try {
            $data['id'] = null;
            $company = null;
            DB::transaction(function () use ($data, &$company) {
                $cnaeIds = $data['cnae_id'];
                unset($data['cnae_id']);
                $company = Empresa::create($data);
                foreach ($cnaeIds as $cnaeId) {
                    EmpresaCnae::create(['empresa_id' => $company->id, 'cnae_id' => $cnaeId]);
                }
            });
            return response()->json(Empresa::where('id', $company->id)->with('cnae')->first(), 201);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao criar uma empresa.', [$e->getMessage()]);
            // Return a JSON response with an error message
            if ($e->getCode() == 23000) {
                return response()->json(['error' => 'Empresa já cadastrada.'], 422);
            }
            return response()->json(['error' => 'Erro ao tentar criar a empresa.'], 422);
        }
    }

    public function update(CompanyValidateRequest $request): JsonResponse
    {
        $data = $request->all();
        try {
            if(isset($data['cnae_id'])) {
                EmpresaCnae::where('empresa_id', $data['id'])->delete();
                foreach ($data['cnae_id'] as $cnaeId) {
                    EmpresaCnae::create(['empresa_id' => $data['id'], 'cnae_id' => $cnaeId]);
                }
                unset($data['cnae_id']);
            }
            Empresa::where('id', $data['id'])->update($data);
            $company = Empresa::where('id', $data['id'])->with('cnae')->first();
            return response()->json($company, 200);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao atualizar uma empresa.', [$e->getMessage()]);
            // Return a JSON response with an error message
            return response()->json(['error' => 'Erro ao atualizar uma empresa.'], 422);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        $client_id = session('client_context', auth()->user()->person->id);
        try {
            Empresa::where('id', $request->id)->where('client_id', $client_id)->delete();
            return response()->json(['message' => 'Empresa excluida com sucesso!'], 200);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao excluir uma empresa.', [$e->getMessage()]);
            // Return a JSON response with an error message
            return response()->json(['error' => 'Erro ao excluir a empresa.'], 422);
        }
    }
    /**
     * Salva o plano de serviço para uma empresa
     * Se o ID do formulário for nulo e não houver um plano em edição, cria um novo plano de serviço.
     * Se houver um plano em edição, atualiza o plano de serviço.
     */
    public function saveBilling(Request $request): JsonResponse
    {
        $idValidation = $request->isMethod('post') ? 'nullable' : 'required';
        $validation = Validator::make($request->all(), [
            'id' => "$idValidation|integer|exists:planos_servicos_contratados,id",
            'empresa_id' => 'required|integer|exists:empresas,id',
            'plano_id' => 'required|exists:planos_servicos,id',
        ], [
            'empresa_id.required' => 'O identificador da empresa é obrigatório.',
            'plano_id.required' => 'Selecione um plano.',
            'plano_id.regex' => 'O plano selecionado é inválido.',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $data = $request->all();
        /*
         * Verifica se a empresa possui um plano em edição.
         * Se houver, atualiza o plano de serviço.
         */
        $data['id'] = PlanoServicoContratado::where('empresa_id', $data['empresa_id'])->whereNull('ativo')->first()['id'] ?? null;
        
        $data['client_id'] = session()->get('client_context') ?? auth()->user()->person->client_id;
        
        $plano = PlanoServico::select('id', 'nome')
        ->with('categoriasPlano:id,nome')
        ->with('servicos')
        ->find($data['plano_id']);
        $empresa = Empresa::select('id', 'faixa_faturamento_id', 'regime_tributario_id', 'total_funcionarios')
        ->with('faixaFaturamento:id,descricao')
        ->with('regimeTributario:id,descricao')
        ->withCount('socios:empresa_id')
        ->withCount('prolabores:empresa_id')
        ->find($data['empresa_id']);

        //Calcula o valor do prolabore conforme a condição
        $valorProlabore = 0;
        $servicoProlabore = $plano->servicos->where('servico_id', 9)->first();
        if (!is_null($servicoProlabore)) {
            list($condicao, $valorCondicao) = $servicoProlabore['condicoes'];
            if ($condicao == 'gt' && $empresa['prolabores_count'] > $valorCondicao) {
                $valorProlabore = ($empresa['prolabores_count'] > $valorCondicao) * $servicoProlabore['valor'];
            }
        }

        //Calcula o valor para folha de pagamento
        $valorServicoFolha = 0;
        $totalFolha = $empresa->total_funcionarios;
        $servicoFolha = $plano->servicos->where('servico_id', 10)->first();
        if (!is_null($servicoFolha)) {
            list($condicao, $valorCondicao) = $servicoFolha['condicoes'];
            if ($condicao == 'gt' && $totalFolha > $valorCondicao) {
                $valorServicoFolha = ($totalFolha > $valorCondicao) * $servicoFolha['valor'];
            }
        }
        
        $valorPlanoServico = $plano->planoServicoFaixasFaturamento
        ->where('faixa_faturamento_id', $empresa->faixa_faturamento_id)
        ->where('regime_tributario_id', $empresa->regime_tributario_id)
        ->first()->valor;
        
        $dadosPlano = [
            'id' => $data['id'],
            'empresa_id' => $data['empresa_id'],
            'client_id' => $data['client_id'],
            'plano' => [
                'id' => $plano->id,
                'valor' => $valorPlanoServico,//Valor do plano
                'pro_labore_obs' => $plano->servicos->where('servico_id', 9)->first()['observacao'],//Observação do pro_labore
                'valor_unitario_pro_labore' => $servicoProlabore->valor,//Valor unitário do pro_labore
                'total_socios' =>  $empresa['prolabores_count'],//Total de sócios que receberão o pro_labore     
                'total_valor_prolabore' => $valorProlabore,//Total do serviço (valor do serviço * total de sócios)
                'folha_pagamento_obs' => $plano->servicos->where('servico_id', 10)->first()['observacao'],//Observação da folha de pagamento
                'valor_unitario_folha_pagamento' => $servicoFolha->valor,//Valor unitário da folha de pagamento
                'total_folha_pagamento' => $empresa['total_funcionarios'],//Total de funcionarios da folha de pagamento
                'valor_folha_pagamento' => $valorServicoFolha,//Total do serviço (valor do serviço * total de funcionarios da folha de pagamento)
                'faixa_faturamento_id' => $empresa['faixa_faturamento_id'],//ID da faixa de faturamento,
                'regime_tributario_id' => $empresa['regime_tributario_id'],//ID do regime tributário
            ],
            //Será preenchido na configuração do pagamento
            'pagamento' => [
                'forma_pgto_id' => null,
                'dia_cobranca' => null
            ]
        ];
        
        // Se o id do plano de serviço contratado for nulo será criado um novo
        if(is_null($dadosPlano['id'])){
            return $this->createCompanyBilling($dadosPlano);
        }

        return $this->editCompanyBilling($dadosPlano);
    }
    /**
     * Cria um plano de servico para uma empresa
     * 
     * @param $dadosPlano Array de dados do plano
     * @return JsonResponse
     */
    protected function createCompanyBilling($dadosPlano): JsonResponse
    {
         try {
            $planoContratado = PlanoServicoContratado::create($dadosPlano);
            return response()->json($planoContratado, 201);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao criar um plano de servico de para uma empresa.', [$e->getMessage()]);            
            return response()->json(['error' => 'Erro ao tentar criar o plano de servico da empresa.'], 422);
        }
    }
    /**
     * Edita um plano contratado existente
     * 
     * @param $dadosPlano Array de dados do plano
     * @return JsonResponse
     */
    protected function editCompanyBilling($dadosPlano): JsonResponse
    {
        try {
            $planoContratado = PlanoServicoContratado::find($dadosPlano['id']);
            $planoContratado->update($dadosPlano);
            return response()->json($planoContratado, 201);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao editar o plano de servico de uma empresa.', [$e->getMessage()]);            
            return response()->json(['error' => 'Erro ao tentar editar o plano de servico da empresa.'], 422);
        }
    }
    /**
     * Lista o plano de servico configurado para uma empresa
     * O plano terá 3 estados permitidos na tabela:
     * - Ativo: é o plano de servico que está valendo para a empresa
     * - Inativo: é o estado inicial o plano quando a empresa ainda não foi criada. Após a criação do plano, ele será ativado
     * - Excluído: o plano que estava ativo e foi excluido para ser substituido pelo inativo. Esse registro nunca deverá ser exibido. Será o histórico do plano excluido
     * 
     * @param Request $request A request com o id da empresa
     * @return JsonResponse
     */
    public function listCompanyBilling(Request $request, $empresaId): JsonResponse
    {
        $empresaId = Validator::make(['empresa_id' => $empresaId],[
            'empresa_id' => 'required|integer|exists:empresas,id'
        ],[
            'empresa_id.required' => 'O id da empresa é obrigatorio',
        ])->validate()['empresa_id'];

        $plano = PlanoServicoContratado::select(['id', 'plano', 'pagamento'])
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->first();        
        return response()->json($plano, 200);
    }

    public function savePayment(Request $request): JsonResponse
    {
        $tiposPagamentos = TiposPagamento::all()->pluck('id')->toArray();
        $validation = Validator::make($request->all(), [
            'plano_servico_contratado_id' => 'required|integer|exists:planos_servicos_contratados,id',
            'forma_pgto_id' => ['required', 'integer', 'in:'.implode(',', $tiposPagamentos)],
            'dia_cobranca' => 'required|integer|min:1|max:31',
        ],[
            'plano_servico_contratado_id.required' => 'O id do plano de servico contratado é obrigatorio',
            'dia_cobranca.required' => 'A data do pagamento é obrigatorio',
            'forma_pgto_id.required' => 'A forma de pagamento é obrigatorio',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first()], 422);
        }
        $data = $validation->validated();
        
        try {
            $planoServicoContratado = PlanoServicoContratado::find($data['plano_servico_contratado_id']);
            $planoServicoContratado->pagamento = [
                'forma_pgto_id' => $data['forma_pgto_id'],
                'dia_cobranca' => $data['dia_cobranca']
            ];
            $planoServicoContratado->save();
            $dadosPagamento = $planoServicoContratado->pagamento;
            return response()->json($planoServicoContratado->pagamento, 201);
        }
        catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao editar o plano de servico de uma empresa.', [$e->getMessage()]);            
            return response()->json(['error' => 'Erro ao tentar editar o plano de servico da empresa.'], 422);
        }
    }
}
