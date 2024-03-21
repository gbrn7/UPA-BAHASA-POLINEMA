<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r_events')->insert([
            'register_start' => Carbon::parse('2024-04-1')->startOfDay(),
            'register_end' => Carbon::parse('2024-04-12')->endOfDay(), 
            'execution' => Carbon::parse('2024-04-30'), 
            'quota' => 120, 
            'remaining_quota' => 100, 
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
