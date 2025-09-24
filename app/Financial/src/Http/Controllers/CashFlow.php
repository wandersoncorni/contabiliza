<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\CashFlow as CashFlowModel;

class CashFlow
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $cashFlows = CashFlowModel::where('licensed_id', $this->licenseId)
            ->with([
                'company:id,nome',
                'chartOfAccount:id,code,name',
                'transaction:id,description',
                'installment:id,installment_number',
                'account:id,bank_name'
            ])->get();
        return response()->json($cashFlows);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'company_id' => 'required|integer|exists:empresas,id',
            'chart_of_account_id' => 'required|integer|exists:chart_of_accounts,id',
            'transaction_id' => 'nullable|integer|exists:transactions,id',
            'installment_id' => 'nullable|integer|exists:installments,id',
            'account_id' => 'required|integer|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'interest' => 'nullable|numeric|min:0|default:0',
            'discount' => 'nullable|numeric|min:0|default:0',
            'type' => 'required|string|max:20|in:credito,debito,transferencia',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $cashFlow = CashFlowModel::create($data);
            return response()->json($cashFlow, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar um lançamento no fluxo de caixa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar um lançamento no fluxo de caixa.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:cash_flow,id',
            'company_id' => 'sometimes|integer|exists:empresas,id',
            'chart_of_account_id' => 'sometimes|integer|exists:chart_of_accounts,id',
            'transaction_id' => 'sometimes|nullable|integer|exists:transactions,id',
            'installment_id' => 'sometimes|nullable|integer|exists:installments,id',
            'account_id' => 'sometimes|integer|exists:accounts,id',
            'amount' => 'sometimes|numeric|min:0',
            'paid_amount' => 'sometimes|numeric|min:0',
            'interest' => 'sometimes|numeric|min:0',
            'discount' => 'sometimes|numeric|min:0',
            'type' => 'sometimes|string|max:20|in:credito,debito,transferencia',
            'transaction_date' => 'sometimes|date',
            'description' => 'sometimes|nullable|string',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $cashFlow = CashFlowModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($cashFlow, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar um lançamento no fluxo de caixa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar um lançamento no fluxo de caixa.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $cashFlow = CashFlowModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $cashFlow->delete();
            return response()->json(['message' => 'Lançamento no fluxo de caixa excluído com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir um lançamento no fluxo de caixa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir um lançamento no fluxo de caixa.'], 400);
        }
    }
}