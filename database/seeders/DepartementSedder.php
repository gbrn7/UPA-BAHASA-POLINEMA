<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class DepartementSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_departement')->insert([
            ['name' => 'Teknik Elektro'],
            ['name' => 'Teknik Mesin'],
            ['name' => 'Teknologi Informasi'],
        ]);
    }
}
