<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\ChartOfAccount as ChartOfAccountModel;

class ChartOfAccount
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $charts = ChartOfAccountModel::where('licensed_id', $this->licenseId)
            ->with([
                'company:id,nome',
                'parent:id,code,name',
                'children:id,code,name'
            ])->get();
        return response()->json($charts);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:chart_of_accounts,code',
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:20|in:asset,liability,revenue,expense',
            'parent_id' => 'nullable|integer|exists:chart_of_accounts,id',
            'company_id' => 'required|integer|exists:empresas,id',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $chart = ChartOfAccountModel::create($data);
            return response()->json($chart, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma conta no plano de contas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma conta no plano de contas.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:chart_of_accounts,id',
            'code' => 'sometimes|string|max:20|unique:chart_of_accounts,code,' . $request->input('id'),
            'name' => 'sometimes|string|max:100',
            'type' => 'sometimes|string|max:20|in:asset,liability,revenue,expense',
            'parent_id' => 'sometimes|nullable|integer|exists:chart_of_accounts,id',
            'company_id' => 'sometimes|integer|exists:empresas,id',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $chart = ChartOfAccountModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($chart, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar uma conta no plano de contas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma conta no plano de contas.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $chart = ChartOfAccountModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $chart->delete();
            return response()->json(['message' => 'Conta do plano de contas excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma conta no plano de contas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma conta no plano de contas.'], 400);
        }
    }
}