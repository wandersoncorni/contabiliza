<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Application\Models\Licenciado;

class LicenciadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Licenciado::factory()->create();
    }
}
