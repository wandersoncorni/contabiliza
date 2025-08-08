<?php

namespace Database\Seeders;

use App\Application\Database\Seeders\AuxiliaresSeeder;
use App\Application\Database\Seeders\LicensedSeeder;
use App\AccessControl\Database\Seeders\RbacSeeder;
use App\Application\Database\Seeders\PlanosSeeder;
use App\Application\Database\Seeders\NaturezaJuridicaSeeder;
use App\Application\Database\Seeders\FaixaFaturamentoSeeder;
use App\AccessControl\Database\Seeders\UserSeeder;
use App\Application\Database\Seeders\PersonSeeder;
use App\Application\Database\Seeders\RegimeBensSeeder;
use App\Application\Database\Seeders\CnaeSeeder;
use App\Application\Database\Seeders\RegimeTributarioSeeder;
use App\Application\Database\Seeders\AreaAtividadeSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->truncateTables();

        $regimeBensSeeder = new RegimeBensSeeder();
        $regimeBensSeeder->run();

        $userSeeder = new UserSeeder();
        $userSeeder->run();

        $licensedSeeder = new LicensedSeeder();
        $licensedSeeder->run();

        $personSeeder = new PersonSeeder();
        $personSeeder->run();

        $rbacSeeder = new RbacSeeder();
        $rbacSeeder->run();

        $naturezaJuridicaSeeder = new NaturezaJuridicaSeeder();
        $naturezaJuridicaSeeder->run();

        $faixaFaturamentoSeeder = new FaixaFaturamentoSeeder();
        $faixaFaturamentoSeeder->run();

        $planosSeeder = new PlanosSeeder();
        $planosSeeder->run();

        $cnae = new CnaeSeeder();
        $cnae->run();

        $regimeTributario = new RegimeTributarioSeeder();
        $regimeTributario->run();

        $areaAtuacao = new AreaAtividadeSeeder();
        $areaAtuacao->run();

        $auxiliaresSeeder = new AuxiliaresSeeder();
        $auxiliaresSeeder->run();
    }
    /**
     * Truncate all tables except migrations.
     */
    protected function truncateTables(): void
    {
        Schema::disableForeignKeyConstraints();

        $tables = DB::select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'contabiliza' AND table_name != 'migrations'
        ");

        foreach ($tables as $table) {
            if ($table->table_name !== 'migrations') {
                DB::table($table->table_name)->truncate();
            }
        }

        // Reabilita verificação de chave estrangeira
        Schema::enableForeignKeyConstraints();
    }
}
