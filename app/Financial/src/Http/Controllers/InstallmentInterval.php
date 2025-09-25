<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\InstallmentInterval as InstallmentIntervalModel;

class InstallmentInterval
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    /**
     * Retorna todos os intervalos de parcelas
     */
    public function list(): JsonResponse
    {
        $intervals = InstallmentIntervalModel::where('licensed_id', $this->licenseId)
            ->with(['paymentConditions:id,description'])
            ->get();
        return response()->json($intervals);
    }

    /**
     * Cria um novo intervalo de parcelas
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'installment' => 'required|integer|min:1',
            'interval' => 'required|integer|min:0',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $interval = InstallmentIntervalModel::create($data);
            return response()->json($interval, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar um intervalo de parcelas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar um intervalo de parcelas.'], 400);
        }
    }

    /**
     * Atualiza um intervalo de parcelas
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:installment_intervals,id',
            'installment' => 'sometimes|integer|min:1',
            'interval' => 'sometimes|integer|min:0',
            'percentage' => 'sometimes|numeric|min:0|max:100',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $interval = InstallmentIntervalModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($interval, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar um intervalo de parcelas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar um intervalo de parcelas.'], 400);
        }
    }

    /**
     * Exclui um intervalo de parcelas
     */
    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $interval = InstallmentIntervalModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $interval->delete();
            return response()->json(['message' => 'Intervalo de parcelas excluído com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir um intervalo de parcelas.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir um intervalo de parcelas.'], 400);
        }
    }
}