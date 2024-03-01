<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryPOI as ModelPOI;

class CategoryPOI extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            [
                'nama_category' => 'AKI',
            ],
            [
                'nama_category' => 'Rumah Sakit',
            ],
        ];

        ModelPOI::insert($category);
    }
}
