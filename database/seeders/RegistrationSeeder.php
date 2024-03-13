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
            'activity_id' => 1,
            'name' => 'Muhammad Rayhan Gibran',
            'nim' => '2141762099',
            'email' => '2141762099@gmail.com',
            'no_telepon' => '082132679938',
            'departement' => 'Teknologi Informasi',
            'program_study' => 'D4 Sistem Informasi Bisnis',
            'created_at' => now(),
            'updated_at' => now(),
        ]); 
    }
}
