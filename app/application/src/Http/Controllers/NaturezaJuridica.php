<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Application\Models\NaturezaJuridica as NaturezaJuridicaModel;

class NaturezaJuridica
{
    public function list(Request $request, $id = null) : JsonResponse
    {
        $naturezas = NaturezaJuridicaModel::select('id', 'descricao')
            ->when($id, function ($query) use ($id) {
                return $query->where('codigo', $id);
            })
            ->get();

        return response()->json($naturezas);
    }
}