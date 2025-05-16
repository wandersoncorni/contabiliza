<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Companies
{
    public function list() : JsonResponse
    {
        return response()->json([]);
    }
}