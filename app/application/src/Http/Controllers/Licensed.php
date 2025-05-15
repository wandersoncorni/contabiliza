<?php

namespace App\Application\Http\Controllers;

use App\Application\Models\Licensed AS LicensedModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Licensed
{
    public function list(Request $request):  JsonResponse
    {
        return response()->json(LicensedModel::all(), 200);
    }

    public function listLicensed(Request $request, $id):  JsonResponse
    {
        return response()->json(LicensedModel::find($id), 200);
    }

    
}
