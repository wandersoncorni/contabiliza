<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\PaymentCondition as PaymentConditionModel;

class PaymentCondition
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $paymentConditions = PaymentConditionModel::where('licensed_id', $this->licenseId)
            ->with(['installmentInterval:id,installment,interval'])
            ->get();
        return response()->json($paymentConditions);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'installment_interval_id' => 'required|integer|exists:installment_intervals,id',
            'description' => 'required|string|max:100',
            'payment_type' => 'required|string|max:20|in:dinheiro,cartao,boleto,pix',
            'weekend_due_date' => 'required|string|max:20|in:keep,next_business_day,last_business_day',
            'display_in' => 'required|string|max:20|in:compras,vendas,ambos',
            'issues_invoice' => 'boolean',
            'allows_down_payment' => 'boolean',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $paymentCondition = PaymentConditionModel::create($data);
            return response()->json($paymentCondition, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma condição de pagamento.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma condição de pagamento.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:payment_conditions,id',
            'installment_interval_id' => 'sometimes|integer|exists:installment_intervals,id',
            'description' => 'sometimes|string|max:100',
            'payment_type' => 'sometimes|string|max:20|in:dinheiro,cartao,boleto,pix',
            'weekend_due_date' => 'sometimes|string|max:20|in:keep,next_business_day,last_business_day',
            'display_in' => 'sometimes|string|max:20|in:compras,vendas,ambos',
            'issues_invoice' => 'sometimes|boolean',
            'allows_down_payment' => 'sometimes|boolean',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $paymentCondition = PaymentConditionModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($paymentCondition, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar uma condição de pagamento.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma condição de pagamento.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $paymentCondition = PaymentConditionModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $paymentCondition->delete();
            return response()->json(['message' => 'Condição de pagamento excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma condição de pagamento.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma condição de pagamento.'], 400);
        }
    }
}