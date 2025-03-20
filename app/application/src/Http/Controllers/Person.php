<?php

namespace App\Application\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Models\People;
/**
 * Class Cliente para gerenciar os dados do cliente
 * O cliente eh a pessoa que se cadastrou pela pagina de cadastro da area publica da aplicacao.
 * Apos o cadastro o usuario serah direcionado a area privada da aplicacao e completara os dados do seu perfil,
 * que serao salvos na tabela de pessoas.
 */
class Person
{
    /**
     * Metodo para listar os clientes cadastrados
     * 
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(['message' => 'Listagem de clientes']);
    }

    public function create(Resquest $request)
    {
        //
    }   

    public function update(){
        //
    }   

    public function delete(){
        //
    }   


}
