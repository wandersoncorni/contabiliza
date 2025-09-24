<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\Models\PeopleCompany as PeopleCompanyModel;

class PeopleCompany
{
    protected $licenseId = null;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function list(): JsonResponse
    {
        $people = PeopleCompanyModel::where('licensed_id', $this->licenseId)
            ->with(['company:id,nome'])
            ->get();
        return response()->json($people);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'company_id' => 'required|integer|exists:empresas,id',
            'name' => 'required|string|max:100',
            'tax_id' => 'nullable|string|max:20',
            'type' => 'required|string|max:20|in:cliente,fornecedor,transportadora',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:100',
            'complement' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            'number' => 'nullable|string|max:20',
            'phone1' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state_registration' => 'nullable|string|max:20',
            'trade_name' => 'nullable|string|max:100',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $person = PeopleCompanyModel::create($data);
            return response()->json($person, 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma pessoa/empresa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao criar uma pessoa/empresa.'], 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:people_company,id',
            'company_id' => 'sometimes|integer|exists:empresas,id',
            'name' => 'sometimes|string|max:100',
            'tax_id' => 'sometimes|nullable|string|max:20',
            'type' => 'sometimes|string|max:20|in:cliente,fornecedor,transportadora',
            'email' => 'sometimes|nullable|email|max:100',
            'phone' => 'sometimes|nullable|string|max:20',
            'zipcode' => 'sometimes|nullable|string|max:10',
            'address' => 'sometimes|nullable|string|max:100',
            'complement' => 'sometimes|nullable|string|max:50',
            'district' => 'sometimes|nullable|string|max:50',
            'number' => 'sometimes|nullable|string|max:20',
            'phone1' => 'sometimes|nullable|string|max:20',
            'phone2' => 'sometimes|nullable|string|max:20',
            'city' => 'sometimes|nullable|string|max:100',
            'state_registration' => 'sometimes|nullable|string|max:20',
            'trade_name' => 'sometimes|nullable|string|max:100',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $person = PeopleCompanyModel::where('id', $data['id'])
                ->where('licensed_id', $this->licenseId)
                ->update($data);
            return response()->json($person, 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar uma pessoa/empresa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao atualizar uma pessoa/empresa.'], 400);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        try {
            $person = PeopleCompanyModel::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $person->delete();
            return response()->json(['message' => 'Pessoa/empresa excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir uma pessoa/empresa.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao excluir uma pessoa/empresa.'], 400);
        }
    }
}