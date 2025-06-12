<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Servico;
use App\Application\Models\PlanoServicoCategoria;
use App\Application\Models\CategoriaServico;
use App\Application\Models\PlanoServico;

class PlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planos = [
            'Bronze',
            'Prata',
            'Ouro',
        ];
        $cores = [
            '#CD7F32',
            '#C0C0C0',
            '#FFC107',
        ];
        foreach ($planos as $i=>$plano) {
            PlanoServico::factory()->create([
                'nome' => $plano,
                'descricao' => "Plano $plano",
                'valor_mensal' => rand(300, 500),
                'valor_anual' => rand(100, 300),
                'licensed_id' => 1,
                'posicaao' => $i,
                'cor' => $cores[$i],
            ]);
        }

        $servicos = [
            'Abertura de empresa gratuita',
            'Contabilidade completa',
            'Certificado digital gratuito',
            'Chat e WhatsApp',
            'Telefone',
            'Reunião com especialistas',
            'Emissão de notas pelo nosso time',
            'Emissor de Notas Fiscais'
        ];
        foreach ($servicos as $servico) {
            Servico::factory()->create([
                'nome' => $servico,
                'licensed_id' => 1,
            ]);
        }

        $categorias = [
            'Contabilidade',
            'Atendimento',
            'Emissão de Notas',
        ];
        foreach ($categorias as $categoria) {
            CategoriaServico::factory()->create([
                'nome' => $categoria,
                'licensed_id' => 1,
            ]);
        }
        $planosServicosCategorias = [
            // Plano 1 - Bronze
            [[1,1,1],[1,1,2],[1,2,4]],
            // Plano 2 - Prata
            [[2,1,1],[2,1,2],[2,1,3],[2,2,4],[2,2,5],[2,3,7]],
            // Plano 3 - Ouro
            [[3,1,1],[3,1,2],[3,1,3],[3,2,4],[3,2,5],[3,2,6],[3,3,7],[3,3,8]],
            // Plano 3 - Ouro
        ];

        foreach($planosServicosCategorias as $psc){
            foreach($psc as $pscItem){
                PlanoServicoCategoria::factory()->create([
                    'plano_servico_id' => $pscItem[0],
                    'categoria_servico_id' => $pscItem[1],
                    'servico_id' => $pscItem[2],
                    'licensed_id' => 1
                ]);
            }
        }
    }
}
