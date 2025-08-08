<?php

namespace App\Application\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Application\Models\Licensed;

class LicensedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            ['name' => 'Contabiliza'],
            ['name' => 'licensed 2'],
            ['name' => 'licensed 3'],
            ['name' => 'licensed 4'],
            ['name' => 'licensed 5'],
        ];
        foreach ($data as $item) {
            Licensed::factory()->create($item);
        }
    }
}
