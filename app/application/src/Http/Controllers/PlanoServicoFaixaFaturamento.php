<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\Models\FaixaFaturamento as FaixaFaturamentoModel;
use App\Application\Models\PlanoServicoFaixaFaturamento as PlanoServicoFaixaFaturamentoModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlanoServicoFaixaFaturamento
{
    /**
     * Retorna as faixas de faturamento disponíveis.
     * 
     *@param int $pid O id do plano de serviço
     * @return JsonResponse
     */
    public function list($pid = null): JsonResponse
    {
        $licensedId = session('licensed_context', auth()->user()->person->license_id);
        $query  = FaixaFaturamentoModel::select('id', 'descricao')->where('ativo', true);
        if (!is_null($pid)) {
            $query->where('plano_servico_id', $pid);
        }
        $query->where('licensed_id', session('licensed_context', $licensedId));

        return response()->json($query->get(), 200);
    }

    public function listPlanoFaixaFaturamento($pid, $ffid): JsonResponse
    {        
        $licensedId = session('licensed_context', auth()->user()->person->license_id);
        $validation = Validator::make(['pid' => $pid, 'ffid' => $ffid], [
            'pid' => [
                'required',
                Rule::exists('planos_servicos', 'id')->where('licensed_id', $licensedId),
            ], 
            'ffid' => [
                'required',
                Rule::exists('faixas_faturamento', 'id')->where('licensed_id', $licensedId),
            ], 
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 400);
        }

        $data = $validation->validated();

        $query  = PlanoServicoFaixaFaturamentoModel::select('plano_servico_id', 'faixa_faturamento_id', 'valor')
        ->with('faixaFaturamento:id,descricao,regime_tributario_id')        
        ->with('faixaFaturamento.regimeTributario:id,descricao')
        ->where('plano_servico_id', $data['pid'])
        ->where('faixa_faturamento_id', $data['ffid'])
        ->where('ativo', true);
        return response()->json($query->first(), 200);
    }
}
