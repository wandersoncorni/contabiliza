<?php

namespace App\Application\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class AuxiliaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inserir estados civis
        DB::table('estados_civis')->insert([
            ['descricao' => 'Solteiro', 'ativo' => true],
            ['descricao' => 'Casado', 'ativo' => true],
            ['descricao' => 'Divorciado', 'ativo' => true],
            ['descricao' => 'Viúvo', 'ativo' => true],
            ['descricao' => 'Separado', 'ativo' => true],
            ['descricao' => 'Desquitado', 'ativo' => true],
            ['descricao' => 'União Estável', 'ativo' => true],
            ['descricao' => 'Outros', 'ativo' => true],

        ]);
        // Inserir estados
        DB::table('estados')->insert([
            [ 'sigla'=>'AC', 'descricao' => 'Acre', 'ativo' => 1 ],
            [ 'sigla'=>'AL', 'descricao' => 'Alagoas', 'ativo' => 1 ],
            [ 'sigla'=>'AP', 'descricao' => 'Amapá', 'ativo' => 1 ],
            [ 'sigla'=>'AM', 'descricao' => 'Amazonas', 'ativo' => 1 ],
            [ 'sigla'=>'BA', 'descricao' => 'Bahia', 'ativo' => 1 ],
            [ 'sigla'=>'CE', 'descricao' => 'Ceará', 'ativo' => 1 ],
            [ 'sigla'=>'DF', 'descricao' => 'Distrito Federal', 'ativo' => 1 ],
            [ 'sigla'=>'ES', 'descricao' => 'Espírito Santo', 'ativo' => 1 ],
            [ 'sigla'=>'GO', 'descricao' => 'Goiás', 'ativo' => 1 ],
            [ 'sigla'=>'MA', 'descricao' => 'Maranhão', 'ativo' => 1 ],
            [ 'sigla'=>'MT', 'descricao' => 'Mato Grosso', 'ativo' => 1 ],
            [ 'sigla'=>'MS', 'descricao' => 'Mato Grosso do Sul', 'ativo' => 1 ],
            [ 'sigla'=>'MG', 'descricao' => 'Minas Gerais', 'ativo' => 1 ],
            [ 'sigla'=>'PA', 'descricao' => 'Pará', 'ativo' => 1 ],
            [ 'sigla'=>'PB', 'descricao' => 'Paraíba', 'ativo' => 1 ],
            [ 'sigla'=>'PR', 'descricao' => 'Paraná', 'ativo' => 1 ],
            [ 'sigla'=>'PE', 'descricao' => 'Pernambuco', 'ativo' => 1 ],
            [ 'sigla'=>'PI', 'descricao' => 'Piauí', 'ativo' => 1 ],
            [ 'sigla'=>'RJ', 'descricao' => 'Rio de Janeiro', 'ativo' => 1 ],
            [ 'sigla'=>'RN', 'descricao' => 'Rio Grande do Norte', 'ativo' => 1 ],
            [ 'sigla'=>'RS', 'descricao' => 'Rio Grande do Sul', 'ativo' => 1 ],
            [ 'sigla'=>'RO', 'descricao' => 'Rondônia', 'ativo' => 1 ],
            [ 'sigla'=>'RR', 'descricao' => 'Roraima', 'ativo' => 1 ],
            [ 'sigla'=>'SC', 'descricao' => 'Santa Catarina', 'ativo' => 1 ],
            [ 'sigla'=>'SP', 'descricao' => 'São Paulo', 'ativo' => 1 ],
            [ 'sigla'=>'SE', 'descricao' => 'Sergipe', 'ativo' => 1 ],
            [ 'sigla'=>'TO', 'descricao' => 'Tocantins', 'ativo' => 1 ],
        ]);
    }
};
