<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseEventScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r_course_event_schedule')->insert([
            'course_event_type_course_id' => 1,
            'quota' => 200,
            'remaining_quota' => 200,
            'day_name' => 'Senin',
            'time_start' => '15.30',
            'time_end' => '16.30',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,        
        ]);
    }
}
