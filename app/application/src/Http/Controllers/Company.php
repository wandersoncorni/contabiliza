<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\CompanyValidateRequest;
use App\Application\Models\Empresa;
use App\Application\Models\PlanoServicoContratado;
use App\Application\Models\PlanoServico;
use App\Application\Models\TiposPagamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Company
{
    public function list(): JsonResponse
    {
        return response()->json(Empresa::all());
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
            $company = Empresa::create($data);
            return response()->json($company, 201);
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
            Empresa::where('id', $data['id'])->update($data);
            $company = Empresa::find($data['id']);
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
            'plano_id' => 'required|regex:/^\d\.\d$/',
        ], [
            'empresa_id.required' => 'O identificador da empresa é obrigatório.',
            'plano_id.required' => 'Selecione um plano.',
            'plano_id.regex' => 'O plano selecionado é inválido.',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $data = $request->all();
        //Verifica se a empresa possui um plano em edição
        $data['id'] = PlanoServicoContratado::where('empresa_id', $data['empresa_id'])->whereNull('ativo')->first()['id'] ?? null;
        
        $data['client_id'] = session()->get('client_context') ?? auth()->user()->person->client_id;
        /**
         * @var int $pid - O id do plano
         * @var int $vpid - O id do valor do plano
         */
        list($pid, $vpid) = explode('.', $data['plano_id']);

        $plano = PlanoServico::find($pid);
        $categorias = $plano->categorias()->get();
        $empresa = Empresa::find($data['empresa_id']);
        $socios = $empresa->socios()->where('client_id', $data['client_id'])->get();
        
        $servicos = $plano->servicos()->get();

        //Totaliza os pro_labore a serem pagos
        $totalizarProlabpre = function ($socios) {
            $pro_labore = 0;
            foreach ($socios as $socio) {
                $pro_labore += $socio->pro_labore;
            }
            return $pro_labore;
        };
        $totalProlabore = $totalizarProlabpre($socios);

        //Calcula o valor do prolabore conforme a condição
        $valorProlabore = 0;
        $servicoProlabore = $plano->valoresServicos->where('servico_id', 9)->first();
        if (!is_null($servicoProlabore)) {
            list($condicao, $valorCondicao) = $servicoProlabore->condicoes;
            if ($condicao == 'gt' && $totalProlabore > $valorCondicao) {
                $valorProlabore = ($totalProlabore > $valorCondicao) * $servicoProlabore->valor;
            }
        }

        //Calcula o valor para folha de pagamento
        $valorServicoFolha = 0;
        $totalFolha = $empresa->total_funcionarios;
        $servicoFolha = $plano->valoresServicos->where('servico_id', 10)->first();
        if (!is_null($servicoFolha)) {
            list($condicao, $valorCondicao) = $servicoFolha->condicoes;
            if ($condicao == 'gt' && $totalFolha > $valorCondicao) {
                $valorServicoFolha = ($totalFolha > $valorCondicao) * $servicoFolha->valor;
            }
        }

        //Valor da faixa de faturamento
        $valorAdicionalFaturamento = 0;
        $adicionalFaixaFaturamento = $plano->faixasFaturamento()->where('faixa_faturamento_id', $empresa->faixa_faturamento_id)->first();
        if (!is_null($adicionalFaixaFaturamento)) {
            $valorAdicionalFaturamento = $adicionalFaixaFaturamento->valor;
        }
        $valorPlanoServico = $plano->valorPlanoServico()->where('id', $vpid)->first();
        $dadosPlano = [
            'id' => $data['id'],
            'empresa_id' => $data['empresa_id'],
            'client_id' => $data['client_id'],
            'plano' => [
                'id' => $pid,
                'valor' => $valorPlanoServico->valor,//Valor do plano
                'valor_plano_servico_id' => $valorPlanoServico->id,//Periodicidade do plano
                'pro_labore_obs' => $categorias->where('servico_id', 9)->first()['observacao'],//Observação do pro_labore
                'valor_unitario_pro_labore' => $servicoProlabore->valor,//Valor unitário do pro_labore
                'total_socios' =>  $totalProlabore,//Total de sócios que receberão o pro_labore     
                'total_valor_prolabore' => $valorProlabore,//Total do serviço (valor do serviço * total de sócios)
                'folha_pagamento_obs' => $categorias->where('servico_id', 10)->first()['observacao'],//Observação da folha de pagamento
                'valor_unitario_folha_pagamento' => $servicoFolha->valor,//Valor unitário da folha de pagamento
                'total_folha_pagamento' => $empresa['total_funcionarios'],//Total de funcionarios da folha de pagamento
                'valor_folha_pagamento' => $valorServicoFolha,//Total do serviço (valor do serviço * total de funcionarios da folha de pagamento)
                'faixa_faturamento_id' => $empresa['faixa_faturamento_id'],//ID da faixa de faturamento,
                'faixa_faturamento_obs' => $categorias->where('servico_id', 11)->first()['observacao'],//Observação da faixa de faturamento
                'faixa_faturamento' => $empresa->faixaFaturamento()->first()['descricao'],//Faixa de faturamento
                'valor_faixa_faturamento' => $valorAdicionalFaturamento
            ],
            'pagamento' => [
                'forma_pgto_id' => null,
                'dia_cobranca' => null
            ] //Será preenchido na configuração do pagamento
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
