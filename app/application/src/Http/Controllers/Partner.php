<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\PartnerValidateResquest;
use App\Application\Models\EmpresaSocio;
use App\Application\Models\Empresa;
use App\Application\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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

        return response()->json(Empresa::select('id')
        ->where('client_id', $this->client_id)
            ->where('id', $cid)
            ->with(['socios' => function ($query) {
                $query->select('*')
                    ->where('client_id', $this->client_id)
                    ->orderBy('nome');
            }])->get());
            
    }
    /**
     * Cria um novo sócio.
     * @param PartnerValidateResquest $request
     * @return JsonResponse
     */
    public function create(PartnerValidateResquest $request): JsonResponse
    {
        //Verifica se a empresa existe e pertence ao cliente
        if(Empresa::where([['id', $request->company_id,['client_id', $this->client_id]]])->doesntExist()) {
            return response()->json(['message' => 'Empresa não encontrada ou não pertence ao cliente'], 404);
        }
        $partner = null;
        try{
            $data = $request->all();
            $company_id = $data['company_id'];
            unset($data['company_id']);
            //Cria o sócio
            $partner = Socio::create($data);
            if(!$partner) {
                return response()->json(['error' => 'Erro ao criar sócio'], 500);
            }
            //Vincula o sócio à empresa
            if(EmpresaSocio::create([
                'empresa_id' => $company_id,
                'socio_id'   => $partner->id,
            ]) === false) {
                $partner->delete();
                return response()->json(['error' => 'Erro ao vincular sócio à empresa'], 500);
            }
            return response()->json($partner, 201);
        } catch (\Exception $e) {
            if(!is_null($partner)) {
                $partner->delete();
            }
            // Log the error or handle it as needed
            Log::channel('database')->error('Erro ao criar sócio: ' . $e->getMessage());

            if($e->getCode() == 23000) {
                return response()->json(['errors' => ['cpf' => 'CPF já cadastrado!']], 400);
            }

            return response()->json(['error' => 'Erro ao criar sócio.'], 500);
        }
    }

    public function update(PartnerValidateResquest $request): JsonResponse
    {
        $data = $request->all();
        $sid = $request->id;
        unset($data['id']);
        if(Socio::where('id', $sid)->update($data)) {
            return response()->json(Socio::find($sid), 200);
        }
        
        return response()->json(['rerror' => 'Ocorreu um erro ao atualizar os dados do sócio'], 500);
    }

    public function delete($id): JsonResponse
    {
        // Logic to delete a partner
        return response()->json(['message' => 'Partner deleted successfully']);
    }
}
