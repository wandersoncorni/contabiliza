<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Cnae;

class CnaeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cnaes = [
            ["codigo" => "A", "descricao" => "Agricultura, pecuária, produção florestal, pesca e aqüicultura"],
            ["codigo" => "B", "descricao" => "Indústrias extrativas"],
            ["codigo" => "C", "descricao" => "Indústrias de transformação"],
            ["codigo" => "D", "descricao" => "Eletricidade e gás"],
            ["codigo" => "E", "descricao" => "Água, esgoto, atividades de gestão de resíduos e descontaminação"],
            ["codigo" => "F", "descricao" => "Construção"],
            ["codigo" => "G", "descricao" => "Comércio; reparação de veículos automotores e motocicletas"],
            ["codigo" => "H", "descricao" => "Transporte, armazenagem e correio"],
            ["codigo" => "I", "descricao" => "Alojamento e alimentação"],
            ["codigo" => "J", "descricao" => "Informação e comunicação"],
            ["codigo" => "K", "descricao" => "Atividades financeiras, de seguros e serviços relacionados"],
            ["codigo" => "L", "descricao" => "Atividades imobiliárias"],
            ["codigo" => "M", "descricao" => "Atividades profissionais, científicas e técnicas"],
            ["codigo" => "N", "descricao" => "Atividades administrativas e serviços complementares"],
            ["codigo" => "O", "descricao" => "Administração pública, defesa e seguridade social"],
            ["codigo" => "P", "descricao" => "Educação"],
            ["codigo" => "Q", "descricao" => "Saúde humana e serviços sociais"],
            ["codigo" => "R", "descricao" => "Artes, cultura, esporte e recreação"],
            ["codigo" => "S", "descricao" => "Outras atividades de serviços"],
            ["codigo" => "T", "descricao" => "Serviços domésticos"],
            ["codigo" => "U", "descricao" => "Organismos internacionais e outras instituições extraterritoriais"],
        ];

        foreach ($cnaes as $cnae) {
            Cnae::factory()->create([
                'codigo' => $cnae['codigo'], 
                'descricao' => $cnae['descricao']
            ]);
        }
    }
};
