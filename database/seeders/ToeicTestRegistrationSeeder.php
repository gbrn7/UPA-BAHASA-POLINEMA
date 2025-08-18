<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToeicTestRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_toeic_test_registrations')->insert([
            'toeic_test_events_id' => 1,
            'name' => 'Fajar',
            'nik' => '35071333',
            'nim' => '21417323234',
            'departement' => 'Teknologi Informasi',
            'program_study' => 'D4 Sistem Informasi Bisnis',
            'semester' => '4',
            'email' => '21417323234@gmail.com',
            'phone_num' => '21417323234',
            'ktp_img' => 'default.png',
            'ktm_img' => 'default.png',
            'surat_pernyataan_iisma' => 'default.pdf',
            'pasFoto_img' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
