<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\CompanyValidateRequest;
use App\Application\Models\Empresa;
use App\Application\Models\PlanoServicoContratado;
use App\Application\Models\PlanoServico;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Company
{
    public function list() : JsonResponse
    {
        return response()->json(Empresa::where('status', 1)->get());
    }
    /**
     * Metodo para criar uma empresa na aplicação. É uma empresa existente
     * com dados cadastrados nos órgãos competentes
     */
    public function create(CompanyValidateRequest $request) : JsonResponse
    {
        $data = $request->all();

        try{
            $data['id'] = null;
            $company = Empresa::create($data);
            return response()->json($company, 201);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao criar uma empresa.', [$e->getMessage()]);
            // Return a JSON response with an error message
            if($e->getCode() == 23000) {
                return response()->json(['error' => 'Empresa já cadastrada.'], 422);
            }
            return response()->json(['error' => 'Erro ao tentar criar a empresa.'], 422);
        }
    }

    public function update(CompanyValidateRequest $request) : JsonResponse
    {
        $data = $request->all();
        try{
            Empresa::where('id', $data['id'])->update($data);
            $company = Empresa::find($data['id']);
            return response()->json($company, 200);
        }
        catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao atualizar uma empresa.', [$e->getMessage()]);
            // Return a JSON response with an error message
            return response()->json(['error' => 'Erro ao atualizar uma empresa.'], 422);
        }
    }

    public function delete(Request $request) : JsonResponse
    {
        return response()->json([]);
    }
    /**
     * Listas as solicitações para criação de empresas
     */
    public function listCompaniesRequests() : JsonResponse
    {
        // Aqui você pode implementar a lógica para listar as solicitações de empresas
        return response()->json(Empresa::where('status', 2)->get());
    }
    /**
     * Salva o plano de serviço para uma empresa
     */
    public function saveBilling(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'id' => 'nullable|integer|exists:planos_servicos_contratados,id',
            'empresa_id' => 'required|integer|exists:empresas,id',
            'plano_id' => 'required',
        ],[
            'empresa_id.required' => 'O identificador da empresa é obrigatório.',
            'plano_id.required' => 'Selecione um plano.',
        ]);
        
        if($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $data = $request->all();

        $data['client_id'] = session()->get('client_context') ?? auth()->user()->person->client_id;
        /**
         * @var int $pid - O id do plano
         * @var int $vpid - O id do valor do plano
         */
        list($pid, $vpid) = explode('.', $data['plano_id']);

        $empresa = Empresa::find($data['empresa_id']);
        $socios = $empresa->socios()->where('client_id', $data['client_id'])->get();
        $plano = PlanoServico::find($pid);
        $servicos = $plano->servicos()->get();

        //Totaliza os pro_labore a serem pagos
        $totalizarProlabpre = function ($socios){
            $pro_labore = 0;
            foreach($socios as $socio) {
                $pro_labore += $socio->pro_labore;
            }
            return $pro_labore;
        };
        $totalProlabore = $totalizarProlabpre($socios);

        //Calcula o valor do prolabore conforme a condição
        $valorProlabore = 0;
        $servicoProlabore = $plano->valoresServicos->where('servico_id', 9)->first();
        if(!is_null($servicoProlabore)){
            list($condicao, $valorCondicao) = $servicoProlabore->condicoes;
            if($condicao == 'gt' && $totalProlabore > $valorCondicao) {
                $valorProlabore = ($totalProlabore > $valorCondicao) * $servicoProlabore->valor;
            }            
        }

        //Calcula o valor para folha de pagamento
        $valorServicoFolha = 0;
        $totalFolha = $empresa->total_funcionarios;
        $servicoFolha = $plano->valoresServicos->where('servico_id', 10)->first();
        if(!is_null($servicoFolha)){
            list($condicao, $valorCondicao) = $servicoFolha->condicoes;
            if($condicao == 'gt' && $totalFolha > $valorCondicao) {
                $valorServicoFolha = ($totalFolha > $valorCondicao) * $servicoFolha->valor;
            }
        }

        //Valor da faixa de faturamento
        $valorAdicionalFaturamento = 0;
        $adicionalFaixaFaturamento = $plano->faixasFaturamento()->where('faixa_faturamento_id', $empresa->faixa_faturamento_id)->first();
        if(!is_null($adicionalFaixaFaturamento)){
            $valorAdicionalFaturamento = $adicionalFaixaFaturamento->valor;
        }

        $dadosPlano = [
            'plano_id' => $pid,
            'plano' =>[
                'valor_plano_id' => $vpid,
                'valor_plano' => $plano->valorPlanoServico()->where('id', $vpid)->first()->valor,
                'pro_labore' => $totalProlabore,
                'valor_prolabore' => $valorProlabore,
                'folha_pagamento' => $empresa['total_funcionarios'],
                'valor_folha_pagamento' => $valorServicoFolha,
                'faixa_faturamento' => $empresa['faixa_faturamento_id'],
                'valor_faixa_faturamento' => $valorAdicionalFaturamento
            ]
        ];

        $data = array_merge($data, $dadosPlano);
        try{
            $data['id'] = null;
            $planoContratado = PlanoServicoContratado::create($data);
            return response()->json($planoContratado, 201);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::channel('database')->error('Erro ao criar uma empresa.', [$e->getMessage()]);dd($e->getMessage());
            // Return a JSON response with an error message
            if($e->getCode() == 23000) {
                return response()->json(['error' => 'Empresa já cadastrada.'], 422);
            }
            return response()->json(['error' => 'Erro ao tentar criar a empresa.'], 422);
        }
    }
}