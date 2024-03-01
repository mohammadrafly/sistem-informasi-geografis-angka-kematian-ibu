<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryArtikel as ModelArtikel;

class CategoryArtikel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            [
                'nama_category' => 'Kategori Satu',
            ],
            [
                'nama_category' => 'Kategori Dua',
            ],
        ];

        ModelArtikel::insert($category);
    }
}
