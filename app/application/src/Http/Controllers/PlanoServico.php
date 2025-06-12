<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Application\Models\PlanoServico as PlanoServicoModel;

class PlanoServico
{
    protected $licenseId = null;
    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }
    /**
     * Retorna todos os planos de servicos
     */
    public function list(): JsonResponse
    {
        $PlanoServicos = PlanoServicoModel::where('ativo', true)
            ->with(['categoriasServicos.categoria:id,nome', 'categoriasServicos.servico:id,nome'])
            ->get();
        return response()->json($PlanoServicos);
    }
    /**
     * Cria um novo plano de servico
     * 
     * @param Request $request
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'valor_mensal' => 'required|decimal:2',
            'valor_anual' => 'required|decimal:2',
            'ativo' => 'integer',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $PlanoServico = PlanoServicoModel::create($data);
            return response()->json($PlanoServico, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar um plano de servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar um plano de servico.'], 400);
        }
    }
    /**
     * Atualiza um plano de servico 
     * 
     * @param Request $request
     * 
     */
    public function update(Request $request): JsonResponse
    {
        $lid = $this->licenseId;
        $data = $request->validate([
            'id' => 'required|integer',
            'nome' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|string|max:255|nullable',
            'valor_mensal' => 'sometimes|decimal:2',
            'valor_anual' => 'sometimes|decimal:2',
            'ativo' => 'sometimes|integer|in:0,1',
        ]);
        $data['licensed_id'] = $lid;
        try {
            $PlanoServico = PlanoServicoModel::where('id', $data['id'])
                ->where('licensed_id', $lid)
                ->update($data);
            return response()->json($PlanoServico, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar um plano de servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar um plano de servico.'], 400);
        }
    }
    /**
     * Exclui um servico de um plano
     * 
     * @param Request $request
     * @param int $pid - O id do plano
     * @param int $cid - O id da categoria
     * @return JsonResponse
     */
    public function delete(Request $request, $pid): JsonResponse
    {
        try {
            $lid = $this->licenseId;
            PlanoServicoModel::where('id', $pid)
                ->where('licensed_id', $lid)
                ->delete();
            return response()->json(['message' => 'Servico excluido com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma categoria de servico de um plano.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir um servico de um plano.'], 400);
        }
    }
}
