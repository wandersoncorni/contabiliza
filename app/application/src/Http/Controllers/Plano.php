<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Models\Plano AS PlanoModel;

class Plano
{
    public function list() : JsonResponse
    {
        return response()->json(PlanoModel::where('ativo', true)
            ->whereHas('planoCategoria', function ($query) {
                $query->where('ativo', true);
            })
            ->whereHas('planoCategoria.servico', function ($query) {
                $query->where('ativo', true);
            })->get());
    }
}
