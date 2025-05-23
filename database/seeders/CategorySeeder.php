<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kebersihan',
            'Perbaikan',
            'Rumah Tangga',
            'Teknologi',
            'Transportasi',
            'Lainnya'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}