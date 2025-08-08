<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Application\Models\Servico;
use App\Application\Models\PlanoServicoCategoria;
use App\Application\Models\CategoriaServico;
use App\Application\Models\FaixaFaturamento;
use App\Application\Models\PlanoServico;
use App\Application\Models\PlanoServicoFaixaFaturamento;
use App\Application\Models\PlanoServicoValor;
use App\Application\Models\ServicoValor;

class PlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa as tabelas relacionadas
        $this->clearTables();

        $this->criarPlano();

        $this->criarValoresFaixasFaturamento();

        $this->criarServicos();

        $this->criarCategoriasServicos();

        $this->criarPlanoCategoriaServico();        
    }
    /**
     * Limpa as tabelas relacionadas aos planos de serviço
     */
    protected function clearTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PlanoServicoValor::truncate();
        PlanoServicoCategoria::truncate();
        ServicoValor::truncate();
        Servico::truncate();
        CategoriaServico::truncate();
        PlanoServico::truncate();
        PlanoServicoFaixaFaturamento::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    /**
     * Cria os planos de serviço com seus respectivos valores
     */
    protected function criarPlano(): void
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
        $areaAtividade = [
            1 => 'Comércio',
            2 => 'Serviços',
        ];
        $valores = [
            1 => [
                1 => 299.90, // Bronze
                2 => 449.90, // Prata
                3 => 599.90, // Ouro
            ],
            2 => [
                1 => 199.90,
                2 => 299.90,
                3 => 349.90,
            ],
        ];
        $regimesTributarios = [
            1 => 'Simples Nacional',
            2 => 'Lucro Presumido',
        ];
        // Cria os planos
        foreach ($planos as $i => $plano) {
            $plan = PlanoServico::factory()->create([
                'nome' => $plano,
                'descricao' => "Plano $plano",
                'licensed_id' => 1,
                'posicao' => $i,
                'cor' => $cores[$i],
            ]);
            // Cria os valores para cada plano
            foreach ($areaAtividade as $aid => $area) {
                $valorPlano = $valores[$aid][$plan->id];
                PlanoServicoValor::factory()->create([
                    'licensed_id' => 1,
                    'plano_servico_id' => $plan->id,
                    'area_atividade_id' => $aid, // 1 - Comércio, 2 - Serviços
                    'rotulo' => 'Mensal',
                    'valor' => $valorPlano,
                ]);
                PlanoServicoValor::factory()->create([
                    'licensed_id' => 1,
                    'plano_servico_id' => $plan->id,
                    'area_atividade_id' => $aid, // 1 - Comércio, 2 - Serviços
                    'rotulo' => 'Anual',
                    'valor' => (($valorPlano * 12) - ($valorPlano * 12 * 0.1)),
                ]);
            }
        }
    }

    /**
     * Cria os serviços e seus valores
     */
    protected function criarServicos(): void
    {
        $servicos = [
            ['nome' => 'Abertura de empresa gratuita'],
            ['nome' => 'Contabilidade completa'],
            ['nome' => 'Certificado digital gratuito'],
            ['nome' => 'Chat e WhatsApp'],
            ['nome' => 'Telefone'],
            ['nome' => 'Reunião com especialistas'],
            ['nome' => 'Emissão de notas pelo nosso time','valor' => [50, 50, 30], 'condicoes' => ['gt',0, 5, 10]],
            ['nome' => 'Emissor de Notas Fiscais'],
            ['nome' => 'Pró-labore dos sócios', 'valor' => [50, 50, 50], 'condicoes' => ['gt', 2, 3, 4]],
            ['nome' => 'Folha de pagamento', 'valor' => [50, 50, 50], 'condicoes' => ['gt',0, 2, 4]],
            ['nome' => 'Faixa de faturamento', 'valor' => [0, 0, 0], 'condicoes' => ['gt', 30000, 30000, 30000]],
        ];
        // Criar os serviços
        foreach ($servicos as $key => $servico) {
            $sid = Servico::factory()->create([
                'nome' => $servico['nome'],
                'licensed_id' => 1,
            ]);
            if (isset($servico['valor'])) {
                foreach($servico['valor'] as $i => $valor) {
                    ServicoValor::factory()->create([
                        'servico_id' => $sid->id,
                        'plano_servico_id' => $i + 1,
                        'valor' => $valor ?? 0,
                        'condicoes' => json_encode([ $servico['condicoes'][0],$servico['condicoes'][$i+1]]) ?? [],
                    ]);
                }
            }
        }
    }
    /**
     * Cria as faixas de faturamento para os planos de serviço e
     * define os preços
     */
    protected function criarValoresFaixasFaturamento(): void
    {
        /* 
         * Ids dos planos de serviço
         * 1 - Bronze
         * 2 - Prata     
         * 3 - Ouro
         */
        $planoServicoId = PlanoServico::select('id')->where('ativo', 1)->pluck('id')->toArray();

        // Cria as faixas de faturamento para os planos de serviço
        $faixasFaturamento = FaixaFaturamento::select('id', 'regime_tributario_id')->where('ativo', 1)->get()->toArray();
        /* 
         * Cria os preços das faixas de faturamento por regime tributário
         */
        $valoresFaixaPlano = [
            // Simples Nacional
            1 => [
                ['0.00', '0.00', '0.00'],
                ['50.00', '50.00', '50.00'],
                ['100.00', '100.00', '100.00'],
                ['150.00', '150.00', '150.00'],
                ['200.00', '200.00', '200.00'],
                ['250.00', '250.00', '250.00'],
                ['400.00', '350.00', '350.00'],
                ['450.00', '450.00', '450.00'],
                ['550.00', '600.00', '650.00'],
            ],
            // Lucro Presumido
            2 => [
                ['0.00', '0.00', '0.00'],
                ['50.00', '50.00', '50.00'],
                ['100.00', '100.00', '100.00'],
                ['150.00', '150.00', '150.00'],
                ['200.00', '200.00', '200.00'],
                ['300.00', '300.00', '300.00'],
            ],
        ];

        $count = 0;
        foreach ($faixasFaturamento as $faixa) {
            if ($count > 8) {
                $count = 0;
            }
            foreach ($planoServicoId as $psid) {
                
                PlanoServicoFaixaFaturamento::factory()->create([
                    'plano_servico_id' => $psid,
                    'faixa_faturamento_id' => $faixa['id'],
                    'valor' => $valoresFaixaPlano[$faixa['regime_tributario_id']][$count][$psid - 1],
                ]);
            }
            $count++;
        }
    }
    /**
     * Cria as categorias de serviços
     */
    protected function criarCategoriasServicos(): void
    {
        $categorias = [
            'Contabilidade',
            'Atendimento',
            'Emissão de Notas',
            'Serviços Adicionais',
        ];
        foreach ($categorias as $categoria) {
            CategoriaServico::factory()->create([
                'nome' => $categoria,
                'licensed_id' => 1,
            ]);
        }
    }
    /**
     * Cria o relacionamento entre planos, categorias e serviços
     * Formato: [plano_servico_id, categoria_servico_id, servico_id, [observacao]]
     */
    protected function criarPlanoCategoriaServico(): void
    {
        // Relaciomaneto entre planos, categorias e serviços
        $planosCategoriasServicos = [
            // Plano 1 - Bronze
            [
                [1,1,1],//[bronze, contabilidade, abertura de empresa]
                [1,1,2],//[bronze, contabilidade, contabilizade completa]
                [1,2,4],//[bronze, atendimento, whatsapp]
                [1,4,9,'Até 2 Sócios Grátis'],//[bronze, serviço extra, pró-labore]
                [1,4,10,'Cobrado a parte'],//[bronze, servico extra, folha de pagamento]
                [1,4,11,'Até 30.000,00'],//[bronze, servico extra, faixa de faturamento]
            ],
            // Plano 2 - Prata
            [
                [2,1,1],//idem ao plano 1
                [2,1,2],//idem ao plano 1
                [2,1,3],//[prata, contabilidade, Certificado digital gratuito]
                [2,2,4],//idem ao plano 1
                [2,2,5],//[prata, atendimento, telefone]
                [2,3,7,'Até 5 NFs/mês'],//[prata, notas fiscais, Emissão de notas pelo nosso time]
                [2,4,9,'Até 3 Sócios Grátis'],//idem ao plano 1
                [2,4,10,'Até 2 funcionários grátis'],//idem ao plano 1
                [2,4,11,'Até 100.000,00'],//idem ao plano 1
            ],
            // Plano 3 - Ouro
            [
                [3,1,1],//idem ao plano 2
                [3,1,2],//idem ao plano 2
                [3,1,3],//idem ao plano 2
                [3,2,4],//idem ao plano 2
                [3,2,5],//idem ao plano 2
                [3,2,6],//[ouro, atendimento, Reunião com especialistas]
                [3,3,7, 'Até 10 NFs/mês'],
                [3,3,8],//[ouro, notas fiscais, Emissor de Notas Fiscais]
                [3,4,9,'Até 4 Sócios Grátis'],//idem ao plano 1
                [3,4,10,'Até 2 funcionários grátis'],//idem ao plano 1
                [3,4,11,'Até 200.000,00']//idem ao plano 1
            ]
        ];

        foreach($planosCategoriasServicos as $psc){
            foreach($psc as $pscItem){
                PlanoServicoCategoria::factory()->create([
                    'plano_servico_id' => $pscItem[0],
                    'categoria_servico_id' => $pscItem[1],
                    'servico_id' => $pscItem[2],
                    'observacao' => $pscItem[3] ?? null,
                    'licensed_id' => 1
                ]);
            }
        }
    }
}
