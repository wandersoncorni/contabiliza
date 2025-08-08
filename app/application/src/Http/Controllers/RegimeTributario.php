<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Application\Models\RegimeTributario as RegimeBensModel;

class RegimeTributario
{
    public function list() : JsonResponse
    {
        return response()->json(RegimeBensModel::All());
    }
}
