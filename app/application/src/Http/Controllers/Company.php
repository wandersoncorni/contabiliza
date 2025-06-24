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
    /**
     * Metodo para criar uma nova empresa
     */
    public function create(Request $request) : JsonResponse
    {
        dd($request->all());
        return response()->json([]);
    }

    public function update(Request $request) : JsonResponse
    {
        return response()->json([]);
    }

    public function delete(Request $request) : JsonResponse
    {
        return response()->json([]);
    }
}