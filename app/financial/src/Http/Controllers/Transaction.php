<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\Transaction as TransactionModel;

class Transaction
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $transactions = TransactionModel::where('licensed_id', $this->licenseId)
            ->with([
                'company:id,nome',
                'chartOfAccount:id,code,name',
                'person:id,name',
                'paymentCondition:id,description',
                'installments:id,installment_number'
            ])->get();
        return response()->json($transactions);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'company_id' => 'required|integer|exists:empresas,id',
            'chart_of_account_id' => 'required|integer|exists:chart_of_accounts,id',
            'person_id' => 'nullable|integer|exists:people_company,id',
            'payment_condition_id' => 'required|integer|exists:payment_conditions,id',
            'type' => 'required|string|max:20|in:a pagar,a receber',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'nullable|string|max:20|in:open,paga,vencida',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $transaction = TransactionModel::create($data);
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma transação.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma transação.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:transactions,id',
            'company_id' => 'sometimes|integer|exists:empresas,id',
            'chart_of_account_id' => 'sometimes|integer|exists:chart_of_accounts,id',
            'person_id' => 'sometimes|nullable|integer|exists:people_company,id',
            'payment_condition_id' => 'sometimes|integer|exists:payment_conditions,id',
            'type' => 'sometimes|string|max:20|in:a pagar,a receber',
            'amount' => 'sometimes|numeric|min:0',
            'transaction_date' => 'sometimes|date',
            'payment_date' => 'sometimes|nullable|date',
            'due_date' => 'sometimes|nullable|date',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|string|max:20|in:open,paga,vencida',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $transaction = TransactionModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar uma transação.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma transação.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $transaction = TransactionModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $transaction->delete();
            return response()->json(['message' => 'Transação excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma transação.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma transação.'], 400);
        }
    }
}