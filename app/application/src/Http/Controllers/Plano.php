<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Models\PlanoServicoCategoria;
use App\Application\Models\PlanoServico;

class Plano extends BaseController
{
    /**
     * Listagem de planos
     */
    public function list() : JsonResponse
    {
        $planos = PlanoServico::with(['categoriasServicos.categoria:id,nome', 'categoriasServicos.servico:id,nome'])->get();
        return response()->json($planos);
    }
    /**
     * 
     */
    public function create(Request $request) : JsonResponse
    {
        $data = $request->validate([
            '*.plano_servico_id'     => 'required|integer|exists:planos_servicos,id',
            '*.categoria_servico_id' => 'required|integer|exists:categorias_servicos,id',
            '*.servico_id'           => 'required|integer|exists:servicos,id',
        ]);
        
        foreach($data as $item){
            try{
                PlanoServicoCategoria::firstOrCreate([
                    'plano_servico_id'     => $item['plano_servico_id'],
                    'categoria_servico_id' => $item['categoria_servico_id'],
                    'servico_id'           => $item['servico_id'],
                    'licensed_id'          => $this->licenseId
                ]);
            }
            catch(\Exception $e){
                dd($e->getMessage());
            }                
        }
        
        return response()->json(['message' => 'Planos editado com sucesso!'], 200);
    }
}
