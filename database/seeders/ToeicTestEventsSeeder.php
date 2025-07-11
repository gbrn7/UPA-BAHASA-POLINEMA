<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToeicTestEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r_toeic_test_events')->insert([
            'register_start' => now()->startOfDay(),
            'register_end' => now()->addMonth(1)->endOfDay(),
            'execution' => now()->addDay(40),
            'quota' => 120,
            'remaining_quota' => 119,
            'wa_group_link' => 'https://chat.whatsapp.com/LcO3slKxMsmC62XdXPMm5n',
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
