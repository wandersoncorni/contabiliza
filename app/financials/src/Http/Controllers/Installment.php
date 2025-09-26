<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\Installment as InstallmentModel;

class Installment
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $installments = InstallmentModel::where('licensed_id', $this->licenseId)
            ->with(['transaction:id,description'])
            ->get();
        return response()->json($installments);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'transaction_id' => 'required|integer|exists:transactions,id',
            'installment_number' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_date' => 'nullable|date',
            'status' => 'nullable|string|max:20|in:open,paga,vencida',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $installment = InstallmentModel::create($data);
            return response()->json($installment, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma parcela.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma parcela.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:installments,id',
            'transaction_id' => 'sometimes|integer|exists:transactions,id',
            'installment_number' => 'sometimes|integer|min:1',
            'amount' => 'sometimes|numeric|min:0',
            'due_date' => 'sometimes|date',
            'payment_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|string|max:20|in:open,paga,vencida',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $installment = InstallmentModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($installment, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar uma parcela.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma parcela.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $installment = InstallmentModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $installment->delete();
            return response()->json(['message' => 'Parcela excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma parcela.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma parcela.'], 400);
        }
    }
}