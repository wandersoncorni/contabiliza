<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::factory()->create([
            'nome' => 'Departamento Financeiro',
            'descricao' => 'Responsável pela gestão financeira da empresa, incluindo contas a pagar.'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Administrativo',
            'descricao' => 'Responsável pelas atividades administrativas da empresa.'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Pessoal',
            'descricao' => 'Responsável pela gestão folha de pagamento'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Legal',
            'descricao' => 'Responsável pela abertura, alteração e baixa de empresas.'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Fiscal',
            'descricao' => 'Responsável pelas obrigações fiscais, emissão de nota fiscal, guias de imposto.'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Contábil',
            'descricao' => 'Responsável pelo fechamento contábil.'
        ]);
        Departamento::factory()->create([
            'nome' => 'Departamento Comercial',
            'descricao' => 'Responsável pela gestão comercial.'
        ]);
    }
};
