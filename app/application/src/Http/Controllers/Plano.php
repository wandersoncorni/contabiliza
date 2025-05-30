<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Models\PlanoServicoCategoria;
use App\Application\Models\PlanoServico;

class Plano
{
    public function list() : JsonResponse
    {
        $planos = PlanoServico::with(['categoriasServicos.categoria:id,nome', 'categoriasServicos.servico:id,nome'])->get();
        return response()->json($planos);
    }
}
