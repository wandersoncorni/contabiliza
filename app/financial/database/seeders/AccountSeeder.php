<?php

namespace App\Financial\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Empresa;
use App\Financial\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Cria uma empresa usando a factory
        $company = Empresa::factory()->create();

        // Cria 3 contas bancárias vinculadas à empresa
        Account::create([
            'company_id' => $company->id,
            'bank_name' => 'Banco do Brasil',
            'bank_code' => '001', // Código Febraban do Banco do Brasil
            'agency' => '1234-5',
            'account_number' => '123456-7',
            'digit' => 'X',
            'manager_name' => 'João Silva',
            'contact_phone' => '(11) 99999-0001',
            'account_type' => 'Conta Corrente',
            'status' => 'active',
            'pix_key' => '123.456.789-00', // CPF fictício
            'integration_data' => json_encode(['api_token' => 'bb_token_123']),
            'notes' => 'Conta principal para recebimentos',
        ]);

        Account::create([
            'company_id' => $company->id,
            'bank_name' => 'Itaú Unibanco',
            'bank_code' => '341', // Código Febraban do Itaú
            'agency' => '5678-9',
            'account_number' => '98765-4',
            'digit' => '2',
            'manager_name' => 'Maria Oliveira',
            'contact_phone' => '(21) 98888-0002',
            'account_type' => 'Conta Corrente',
            'status' => 'active',
            'pix_key' => 'maria.oliveira@email.com', // E-mail fictício
            'integration_data' => json_encode(['api_token' => 'itau_token_456']),
            'notes' => 'Conta para pagamentos de fornecedores',
        ]);

        Account::create([
            'company_id' => $company->id,
            'bank_name' => 'Bradesco',
            'bank_code' => '237', // Código Febraban do Bradesco
            'agency' => '4321-0',
            'account_number' => '654321-9',
            'digit' => '1',
            'manager_name' => 'Carlos Souza',
            'contact_phone' => '(31) 97777-0003',
            'account_type' => 'Conta Poupança',
            'status' => 'active',
            'pix_key' => 'chave_aleatoria_789', // Chave PIX aleatória
            'integration_data' => json_encode(['api_token' => 'bradesco_token_789']),
            'notes' => 'Conta reserva para poupança',
        ]);
    }
}