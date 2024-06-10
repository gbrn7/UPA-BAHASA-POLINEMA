<?php

namespace Database\Seeders;

use App\Models\ImageModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImageModel::insert([
            [
                'file_name' => 'gallery-default-4.jpg',
                'type' => 'gallery',
                'created_by' => 1,
            ],
            [
                'file_name' => 'gallery-default-3.jpg',
                'type' => 'gallery',
                'created_by' => 1,
            ],
            [
                'file_name' => 'gallery-default-2.jpg',
                'type' => 'gallery',
                'created_by' => 1,
            ],
            [
                'file_name' => 'gallery-default-1.jpg',
                'type' => 'gallery',
                'created_by' => 1,
            ],
            [
                'file_name' => 'structure-organization-default.png',
                'type' => 'structure_organization',
                'created_by' => 1,
            ],
            [
                'file_name' => 'sop-toeic-default.png',
                'type' => 'sop-toeic',
                'created_by' => 1,
            ],
            [
                'file_name' => 'sop-consult-default.png',
                'type' => 'sop-consult',
                'created_by' => 1,
            ],
        ]);
    }
}
