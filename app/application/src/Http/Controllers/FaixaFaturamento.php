<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\Models\FaixaFaturamento as FaixaFaturamentoModel;

class FaixaFaturamento
{
    /**
     * Retorna as faixas de faturamento disponíveis.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $licensedId = session('licensed_context', auth()->user()->person->license_id);
        return response()->json(FaixaFaturamentoModel::select('id', 'descricao', 'regime_tributario_id')
            ->where('ativo', true)
            ->where('licensed_id', session('licensed_context', $licensedId))
            ->get());
    }
}