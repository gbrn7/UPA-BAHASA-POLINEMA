<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_registrations')->insert([
            'event_id' => 1,
            'name' => 'Muhammad Rayhan Gibran',
            'nik' => '35071333',
            'nim' => '2141762099',
            'departement' => 'Teknologi Informasi',
            'program_study' => 'D4 Sistem Informasi Bisnis',
            'semester' => '4',
            'email' => '2141762099@gmail.com',
            'phone_num' => '082132679938',
            'ktp_img' => 'ktp_2_gibran.png',
            'ktm_img' => 'ktm_2_gibran.png',
            'surat_pernyataan_iisma' => 'iisma_2_gibran.png',
            'pasFoto_img' => 'pasFoto_2_gibran.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]); 
    }
}
