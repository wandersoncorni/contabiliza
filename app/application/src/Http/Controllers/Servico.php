<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Application\Models\Servico as ServicoModel;
use App\Application\Models\PlanoCategoriaServico;
/**
 * Class Cliente para gerenciar os dados do cliente
 * O cliente eh a pessoa que se cadastrou pela pagina de cadastro da area publica da aplicacao.
 * Apos o cadastro o usuario serah direcionado a area privada da aplicacao e completara os dados do seu perfil,
 * que serao salvos na tabela de pessoas.
 */
class Servico
{
    protected $licenseId = null;
    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }
    /**
     * Metodo para listar os clientes cadastrados
     * 
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(ServicoModel::select('id', 'nome')
            ->where('ativo', true)
            ->where('licensed_id', session('licensed_context', auth()->user()->person->license_id))
            ->get());
    }
    /**
     * Exclui um servico de um plano
     * 
     * @param Request $request
     * @param int $pid - O id do plano
     * @param int $cid - O id da categoria
     * @return JsonResponse
     */
    public function excluirServicoPlano(Request $request, $pid, $cid, $sid) : JsonResponse 
    {
        try{
            $lid = $this->licenseId;
            PlanoCategoriaServico::where('plano_servico_id', $pid)
            ->where('categoria_servico_id', $cid)
            ->where('servico_id', $sid)
            ->whereIn('servico_id',function($query)use($sid, $lid){
                $query->select('id')
                ->from('servicos')
                ->where('id', $sid)
                ->where('licensed_id', $lid);
            })
            ->delete();
            return response()->json(['message' => 'Servico excluido com sucesso!'], 200);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao excluir uma categoria de servico de um plano.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir um servico de um plano.'], 400);
        }        
    }

    public function create(Request $request) : JsonResponse 
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
        ]);
        try{
            ServicoModel::create([
                'nome' => $data['nome'],
                'licensed_id' => $this->licenseId
            ]);
            return response()->json(['message' => 'Servico criado com sucesso!'], 200);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao criar um servico.', [$e->getMessage()]);
            dd($e->getMessage());
            return response()->json(['error' => 'Erro ao criar um servico.'], 400);
        }
    }

    public function update(Request $request) : JsonResponse {
        $data = $request->validate([
            'id' => 'required|integer',
            'nome' => 'required|string|max:255',
        ]);
        try{
            ServicoModel::where('id', (int)$data['id'])
            ->where('licensed_id', $this->licenseId)
            ->update([
                'nome' => $data['nome']
            ]);
            return response()->json(['message' => 'Servico atualizado com sucesso!'], 200);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao atualizar um servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar um servico.'], 400);
        }
    }

    public function delete($id) : JsonResponse {
        try{
            ServicoModel::where('id', (int)$id)
            ->where('licensed_id', $this->licenseId)
            ->delete();
            return response()->json(['message' => 'Servico excluido com sucesso!'], 200);
        }
        catch(\Exception $e){
            Log::channel('database')->error('Erro ao excluir um servico.', [$e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir um servico.'], 400);
        }
    }
}
