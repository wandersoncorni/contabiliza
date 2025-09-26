<?php

namespace App\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Financial\src\Models\Account;

class AccountController extends Controller
{
    protected $licenseId;

    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }

    public function index(): JsonResponse
    {
        try {
            $accounts = Account::where('licensed_id', $this->licenseId)->get();
            return response()->json($accounts);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao listar contas.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao listar contas.'], 400);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $account = Account::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            return response()->json($account);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao buscar conta.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao buscar conta.'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'bank_name' => 'required|string|max:100',
            'bank_code' => 'required|string|max:10',
            'agency' => 'required|string|max:10',
            'account_number' => 'required|string|max:20|unique:accounts,account_number',
            'digit' => 'nullable|string|max:2',
            'manager_name' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'account_type' => 'nullable|string|max:50',
            'status' => 'required|in:active,pending,inactive',
            'pix_key' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            $data['licensed_id'] = $this->licenseId;
            $account = Account::create($data);
            return response()->json(['message' => 'Conta criada com sucesso!', 'data' => $account], 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar conta.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao criar conta.'], 400);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'company_id' => 'sometimes|exists:companies,id',
            'bank_name' => 'sometimes|string|max:100',
            'bank_code' => 'sometimes|string|max:10',
            'agency' => 'sometimes|string|max:10',
            'account_number' => 'sometimes|string|max:20|unique:accounts,account_number,' . $id,
            'digit' => 'sometimes|string|max:2|nullable',
            'manager_name' => 'sometimes|string|max:100|nullable',
            'contact_phone' => 'sometimes|string|max:20|nullable',
            'account_type' => 'sometimes|string|max:50|nullable',
            'status' => 'sometimes|in:active,pending,inactive',
            'pix_key' => 'sometimes|string|max:100|nullable',
            'notes' => 'sometimes|string|nullable',
        ]);

        try {
            $account = Account::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $account->update($data);
            return response()->json(['message' => 'Conta atualizada com sucesso!', 'data' => $account]);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao atualizar conta.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao atualizar conta.'], 400);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $account = Account::where('id', $id)
                ->where('licensed_id', $this->licenseId)
                ->firstOrFail();
            $account->delete();
            return response()->json(['message' => 'Conta excluída com sucesso!']);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao excluir conta.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao excluir conta.'], 400);
        }
    }
}