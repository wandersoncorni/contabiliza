<?php

namespace App\Application\Http\Controllers;

use App\AccessControl\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class Consultant
{
    public function list(Request $request, $id = null): JsonResponse
    {
        $lid = Auth::user()->person->licensed_id ?? 0;
        if ($id != null && Auth::user()->hasRole('admin')) {
            $lid = $id;
        }
        return response()->json(User::select([
            'id',
            'email',
            'created_at',
            'active',
            DB::raw('created_at IS NOT NULL as verified')
        ])
            ->where(['active' => 1])
            ->whereHas('person', function ($query) use ($lid) {
                $query->where('licensed_id', $lid)->whereJsonContains('roles', 'consultant');
            })->with('person:user_id,name')->get(), 200);
    }
}
