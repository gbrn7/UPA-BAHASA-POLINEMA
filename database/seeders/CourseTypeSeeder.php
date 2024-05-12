<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_course_type')->insert(
        [
            [
                'name' => 'Test Preparation (TOEIC, TOEFL, IELTS)',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                ],
                [
                'name' => 'Japanese',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                ],
                [
                'name' => 'Mandarin',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                ],
                [
                'name' => 'French',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                ],
                [
                'name' => 'BIPA',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                ],
        ]
    );    
    }
}
