<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\PartnerValidateResquest;
use App\Application\Models\EmpresaSocio;
use App\Application\Models\Empresa;
use App\Application\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Partner
{
    protected $client_id;

    public function __construct()
    {
        // Assuming client_id is set from the authenticated user or request
        $this->client_id = session('client_context') ?? auth()->user()->client_id;
    }
    /**
     * Lista todos os sócios cadastrados pelo cliente.
     */
    public function list(): JsonResponse
    {
        return response()->json([]);
    }
    /**
     * Lista os sócios de uma empresa.
     */
    public function listByCompany($cid): JsonResponse
    {
        return response()->json(Socio::where('client_id', $this->client_id)
            ->where('empresa_id', $cid)
            ->get());            
    }
    /**
     * Cria um novo sócio.
     * @param PartnerValidateResquest $request
     * @return JsonResponse
     */
    public function create(PartnerValidateResquest $request): JsonResponse
    {
        //Verifica se a empresa existe e pertence ao cliente
        if(Empresa::where([['id', $request->empresa_id],['client_id', $this->client_id]])->doesntExist()) {
            return response()->json(['message' => 'Empresa não encontrada ou não pertence ao cliente'], 404);
        }
        $partner = null;
        try{
            $data = $request->all();
            //Cria o sócio
            $partner = Socio::create($data);
            if(!$partner) {
                return response()->json(['error' => 'Erro ao criar sócio'], 500);
            }
            return response()->json($partner, 201);
        } catch (\Exception $e) {
            if(!is_null($partner)) {
                $partner->delete();
            }
            // Log the error or handle it as needed
            Log::channel('database')->error('Erro ao criar sócio: ' . $e->getMessage());dd($e->getMessage());
            if(str_contains($e->getMessage(), 'Duplicate entry')) {
                return response()->json(['error' => 'Já existe um sócio com este CPF para esta empresa.'], 409);
            }

            return response()->json(['error' => 'Erro ao criar sócio.'], 500);
        }
    }

    public function update(PartnerValidateResquest $request): JsonResponse
    {
        $data = $request->all();
        $sid = $request->id;
        $client_id = session('client_context', auth()->user()->person->id);
        unset($data['id']);
        // Força a atualização do regime de bens
        if(isset($data['estado_civil'])){
            $data['regime_bens'] = $data['estado_civil'] == 2 ? $data['regime_bens'] : null;
        }
        if(Socio::where('id', $sid)->where('client_id', $client_id)->update($data)) {
            return response()->json(Socio::find($sid), 200);
        }
        
        return response()->json(['rerror' => 'Ocorreu um erro ao atualizar os dados do sócio'], 500);
    }

    public function delete($id): JsonResponse
    {
        $client_id = session('client_context', auth()->user()->person->id);
        $id = Validator::make(['id' => $id],[
            'id' => 'required|integer|exists:socios,id,client_id,' . $client_id
        ],[
            'id.required' => 'O id do sócio é obrigatorio',
            'id.exists' => 'O id do sócio informado nao existe',
        ])->validate()['id'];

        if(Socio::where('client_id', $client_id)->where('id', $id)->delete()){ 
            return response()->json(['message' => 'Sócio excluido com sucesso'], 200);
        }
        return response()->json(['message' => 'Ocorreu um erro ao excluir o sócio'], 500);
    }
    /**
     * Busca um registro pelo CPF
     * 
     * @param Request $request 
     * @return JsonResponse
     */
    public function searchPartner(Request $request): JsonResponse
    {
        $query = Validator::make($request->all(), 
        ['term' => 'required|regex:/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/'],
        ['term.required' => 'Termo de busca obrigatório e deve ser numérico de 11 digitos.'])->validate();

        $partner = Socio::where('client_id', $this->client_id)
            ->where('cpf', '=', $query['term'])
            ->first();
        if(!$partner) {
            return response()->json(['message' => 'Sócio não encontrado'], 404);
        }
        return response()->json($partner, 200);
    }
}
