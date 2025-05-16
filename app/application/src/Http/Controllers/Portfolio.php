<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Portfolio
{
    public function list() : JsonResponse
    {
        return response()->json([]);
    }
}
