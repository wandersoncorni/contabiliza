<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\Models\Cnae as CnaeModel;

class Cnae
{
    public function list() : JsonResponse
    {
        return response()->json(CnaeModel::where('ativo', 1)->get());
    }
}
