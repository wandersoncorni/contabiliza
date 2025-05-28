<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Application\Models\Empresa;

class EmpressaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        Empresa::new()->create();
    }
}