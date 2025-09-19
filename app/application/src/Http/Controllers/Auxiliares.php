<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Auxiliares
{
    public function listarEstados(): JsonResponse
    {
        $lst = DB::table('estados')
            ->select('id', 'sigla', 'descricao')
            ->orderBy('descricao')
            ->where('ativo', true)
            ->get();
        return response()->json($lst);
    }

    public function listarEstadosCivis()
    {
        $lst = DB::table('estados_civis')
            ->select('id', 'nome')
            ->orderBy('nome')
            ->where('ativo', true)
            ->get();
        return response()->json($lst);
    }
}
