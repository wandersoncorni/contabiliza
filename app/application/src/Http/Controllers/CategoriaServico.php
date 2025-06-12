<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Models\CategoriaServico as CategoriaServicoModel;
use App\Application\Models\PlanoServicoCategoria;
use Illuminate\Support\Facades\Log;

class CategoriaServico
{
    protected $licenseId = null;
    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }
    public function list() : JsonResponse
    {
        return response()->json(CategoriaServicoModel::select('id', 'nome')
        ->where('ativo', true)
        ->where('licensed_id', $this->licenseId)
        ->get());
    }

    public function listCategoriesAndServices(): JsonResponse
    {
        return response()->json(CategoriaServicoModel::select('id', 'nome', 'servicos')
        ->where('ativo', true)
        ->where('licensed_id', $this->licenseId)
        ->whereHas('servicos')
        ->get());
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'sometimes|required|integer',
            'nome' => 'required|string|max:255',
        ]);
        $data['licensed_id'] = $this->licenseId;
        try{
            return response()->json(CategoriaServicoModel::create($data));
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao criar uma categoria de servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma categoria de servico.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|gt:0',
            'nome' => 'required|string|max:255',
        ]);
        $data['licensed_id'] = $this->licenseId;
        try{
            if(CategoriaServicoModel::where('id', $data['id'])->where('licensed_id', $this->licenseId)->update($data)){
                return response()->json(['message' => 'Categoria de servico atualizada com sucesso.'], 200);
            }
            return response()->json(['message' => 'Categoria de serviço não encontrada.'], 400);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao atualizar uma categoria de servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma categoria de servico.'], 400);
        }
    }
    public function delete(Request $request, $id): JsonResponse
    {
        try{
            if(CategoriaServicoModel::where('id', $id)->where('licensed_id', $this->licenseId)->delete()){
                return response()->json(['message' => 'Categoria de servico excluida com sucesso!'], 200);
            }
            return response()->json(['error' => 'Erro ao excluir uma categoria de servico.'], 400);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao excluir uma categoria de servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma categoria de servico.'], 400);
        }
    }
    /**
     * Exclui uma categoria de servico de um plano
     * 
     * @param Request $request
     * @param int $pid - O id do plano
     * @param int $cid - O id da categoria
     * @return JsonResponse
     */
    public function deleteCategoryPlan(Request $request, $pid, $cid) : JsonResponse 
    {
        try{
            $lid = $this->licenseId;
            $req = PlanoServicoCategoria::where('plano_servico_id', $pid)->where('categoria_servico_id', $cid)
            ->whereIn('categoria_servico_id',function($query)use($cid, $lid){
                $query->select('id')
                ->from('categorias_servicos')
                ->where('id', $cid)
                ->where('licensed_id', $lid);
            })
            ->delete();
            return response()->json(['message' => 'Categoria de servico excluida com sucesso!'], 200);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao excluir uma categoria de servico de um plano.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma categoria de servico de um plano.'], 400);
        }
        
    }
}
