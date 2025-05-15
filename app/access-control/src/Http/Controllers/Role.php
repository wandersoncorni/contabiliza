<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\Role AS RoleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Role
{
    public function list(Request $request):  JsonResponse
    {
        $roles = RoleModel::whereNull('deleted_at')->where('id', '!=', '1')->get();
        return response()->json(RoleModel::whereNull('deleted_at')->where('id', '!=', '1')->get(), 200);
    }
}
