<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('d_user')->insert([
            'name' => 'HUB POLINEMA',
            'email' => 'hub@polinema.ac.id',
            'password' => Hash::make('adminpass'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
