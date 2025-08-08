<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\Models\RegimeBens as RegimeBensModel;

class RegimeBens
{
    public function list() : JsonResponse
    {
        return response()->json(RegimeBensModel::where('ativo', 1)->get());
    }
}
