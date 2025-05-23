<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Company
{
    public function list() : JsonResponse
    {
        return response()->json([]);
    }
}