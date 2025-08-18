<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseEventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_course_event_registrations')->insert([
            'course_event_schedule_id' => 1,
            'name' => 'rizky',
            'email' => 'rizky@gmail.com',
            'phone_num' => '0821323234532',
            'address' => 'Jl. Teuku Umar',
            'ktp_or_passport_img' => 'test.png',
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
