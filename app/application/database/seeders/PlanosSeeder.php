<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Application\Models\Servico;
use App\Application\Models\PlanoCategoriaServico;
use App\Application\Models\CategoriaServico;
use App\Application\Models\FaixaFaturamento;
use App\Application\Models\PlanoServico;
use App\Application\Models\PlanoServicoFaixaFaturamento;

class PlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa as tabelas relacionadas
        $this->clearTables();

        $this->criarPlanos();

        $this->criarCategorias();

        $this->criarServicos();

        $this->criarRelacionamentosFaixasFaturamento();

        $this->criarRelacionamentosPlanoCategoriaServico();        
    }
    /**
     * Limpa as tabelas relacionadas aos planos de serviço
     */
    protected function clearTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PlanoCategoriaServico::truncate();
        PlanoServicoFaixaFaturamento::truncate();
        Servico::truncate();
        CategoriaServico::truncate();
        PlanoServico::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    /**
     * Cria os planos de serviço com seus respectivos valores
     */
    protected function criarPlanos(): void
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
        // Cria os planos
        foreach ($planos as $i => $plano) {
            $plan = PlanoServico::factory()->create([
                'nome' => $plano,
                'descricao' => "Plano $plano",
                'licensed_id' => 1,
                'posicao' => $i,
                'cor' => $cores[$i],
            ]);
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
        }
    }
    /**
     * Cria as faixas de faturamento para os planos de serviço e
     * define os preços
     */
    protected function criarRelacionamentosFaixasFaturamento(): void
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
                ['299.90', '399.90', '449.90'],
                ['349.90', '449.90', '499.90'],
                ['349.90', '499.90', '599.90'],
                ['349.90', '499.90', '599.90'],
                ['349.90', '499.90', '599.90'],
                ['599.90', '699.90', '749.90'],
            ],
            // Lucro Presumido
            2 => [
                ['249.90', '349.90', '399.90'],
                ['299.90', '399.90', '449.90'],
                ['349.90', '449.90', '499.90'],
                ['349.90', '449.90', '499.90'],
                ['349.90', '449.90', '499.90'],
                ['349.90', '449.90', '499.90'],
                ['549.90', '649.90', '699.90'],
                ['649.90', '749.90', '799.90'],
                ['749.90', '899.90', '999.90'],
            ],
        ];

        $count = 0;
        $ref = 0;
        foreach ($faixasFaturamento as $faixa) {
            if ($faixa['regime_tributario_id'] != $ref) {
                $ref = $faixa['regime_tributario_id'];
                $count = 0;
            }
            foreach ($planoServicoId as $psid) {                
                PlanoServicoFaixaFaturamento::factory()->create([
                    'plano_servico_id' => $psid,
                    'faixa_faturamento_id' => $faixa['id'],
                    'regime_tributario_id' => $faixa['regime_tributario_id'],
                    'valor' => $valoresFaixaPlano[$faixa['regime_tributario_id']][$count][$psid - 1],
                ]);
            }
            $count++;
        }
    }
    /**
     * Cria as categorias de serviços
     */
    protected function criarCategorias(): void
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
    protected function criarRelacionamentosPlanoCategoriaServico(): void
    {
        // Relaciomaneto entre planos, categorias e serviços
        $planosCategoriasServicos = [
            // Plano 1 - Bronze
            [
                [1,1,1],//[bronze, contabilidade, abertura de empresa]
                [1,1,2],//[bronze, contabilidade, contabilizade completa]
                [1,2,4],//[bronze, atendimento, whatsapp]
                [1,4,9,'Até 2 Sócios Grátis', 50.00, ['gt', 2]],//[bronze, serviço extra, pró-labore]
                [1,4,10,'Cobrado a parte', 10.00, ['gt', 0]],//[bronze, servico extra, folha de pagamento]
            ],
            // Plano 2 - Prata
            [
                [2,1,1],//idem ao plano 1
                [2,1,2],//idem ao plano 1
                [2,1,3],//[prata, contabilidade, Certificado digital gratuito]
                [2,2,4],//idem ao plano 1
                [2,2,5],//[prata, atendimento, telefone]
                [2,3,7,'Até 5 NFs/mês', 20, ['gt', 5]],//[prata, notas fiscais, Emissão de notas pelo nosso time]
                [2,4,9,'Até 3 Sócios Grátis', 40.00, ['gt', 3]],//idem ao plano 1
                [2,4,10,'Até 2 funcionários grátis', 5.00, ['gt', 2]],//idem ao plano 1
            ],
            // Plano 3 - Ouro
            [
                [3,1,1],//idem ao plano 2
                [3,1,2],//idem ao plano 2
                [3,1,3],//idem ao plano 2
                [3,2,4],//idem ao plano 2
                [3,2,5],//idem ao plano 2
                [3,2,6],//[ouro, atendimento, Reunião com especialistas]
                [3,3,7, 'Até 10 NFs/mês', 30, ['gt', 10]],//[ouro, notas fiscais, Emissão de notas pelo nosso time]
                [3,3,8],//[ouro, notas fiscais, Emissor de Notas Fiscais]
                [3,4,9,'Até 4 Sócios Grátis', 30.00, ['gt', 4]],//idem ao plano 1
                [3,4,10,'Até 2 funcionários grátis', 5.00, ['gt', 2]],//idem ao plano 1
            ]
        ];

        foreach($planosCategoriasServicos as $psc){
            foreach($psc as $pscItem){
                PlanoCategoriaServico::factory()->create([
                    'plano_servico_id' => $pscItem[0],
                    'categoria_servico_id' => $pscItem[1],
                    'servico_id' => $pscItem[2],
                    'observacao' => $pscItem[3] ?? null,
                    'valor' => $pscItem[4] ?? null,
                    'condicoes' => $pscItem[5] ?? null,
                ]);
            }
        }
    }
}
