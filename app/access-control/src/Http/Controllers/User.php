<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\ConfirmEmail;
use App\AccessControl\Mail\EmailConfirmacaoEdicao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;

class User
{
    /**
     * Lista os usuarios da aplicacao
     * Filtra o campos desejados na requisicao e retorna somnete os permitidos
     * Campos permitidos: id, name, company, email, photo, username, profile_id, active
     * @param $req Objeto
     * @return String O JSON com os campos ou o erro
     */
    public function list(Request $req): JsonResponse
    {
        $fields = $req->query('fields');

        // Se o parâmetro 'fields' existir, validamos os campos
        if ($fields) {
            // Converte a string de campos separados por virgula em um array
            $fieldsArray = explode(',', $fields);

            // Define os campos permitidos
            $validFields = ['id', 'name', 'company', 'email', 'photo', 'username', 'profile_id', 'active',];

            // Cria uma validacao para garantir que os campos sejam validos
            $validator = Validator::make(
                ['fields' => $fieldsArray],
                [
                    'fields' => 'array', // Verifica se eh um array
                    'fields.*' => 'in:' . implode(',', $validFields) . '|distinct' // Verifica se cada campo eh valido
                ]
            );

            // Se a validacao falhar, retorna um erro
            if ($validator->fails()) {
                $errorsMessages = [];
                foreach ($validator->errors()->getMessages() as $key => $errors) {
                    $invalidField = $fieldsArray[str_replace('fields.', '', $key)];
                    $errorsMessages[] = str_replace($key, $invalidField, current($errors));
                }
                return response()->json($errorsMessages, 400);
            }

            // Filtra os campos validos
            $fieldsArray = array_intersect($fieldsArray, $validFields);

            // Realiza a consulta com os campos filtrados
            $users = UserModel::select($fieldsArray)->with('profile:id,label')->orderBy('name', 'ASC')->get();
        } else {
            // Se não houver o parâmetro 'fields', retorna todos os dados
            $users = UserModel::orderBy('name', 'ASC')->with('profile:id,label')->get();
        }

        return response()->json($users);
        return response()->json([], 200);
    }
}
