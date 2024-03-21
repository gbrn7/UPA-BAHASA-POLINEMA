<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdySedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_prody')->insert([
            ['name' => 'D4 Teknik Informatika'],
            ['name' => 'D4 Teknik Kelistrikan'],
            ['name' => 'D4 Sistem Informasi Bisnis'],
        ]);    
    }
}
