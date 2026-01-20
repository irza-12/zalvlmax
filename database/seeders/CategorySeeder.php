<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Matematika',
                'description' => 'Soal-soal tentang matematika, aljabar, geometri, dan statistika',
                'icon' => 'calculator',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Bahasa Indonesia',
                'description' => 'Soal-soal tentang tata bahasa, sastra, dan penulisan',
                'icon' => 'book-open',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Bahasa Inggris',
                'description' => 'Soal-soal tentang grammar, vocabulary, dan comprehension',
                'icon' => 'globe',
                'color' => '#10B981',
            ],
            [
                'name' => 'IPA',
                'description' => 'Soal-soal tentang fisika, kimia, dan biologi',
                'icon' => 'beaker',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'IPS',
                'description' => 'Soal-soal tentang sejarah, geografi, ekonomi, dan sosiologi',
                'icon' => 'map',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'Teknologi Informasi',
                'description' => 'Soal-soal tentang komputer, programming, dan teknologi',
                'icon' => 'computer-desktop',
                'color' => '#06B6D4',
            ],
            [
                'name' => 'Pengetahuan Umum',
                'description' => 'Soal-soal tentang pengetahuan umum dan wawasan',
                'icon' => 'light-bulb',
                'color' => '#EC4899',
            ],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'color' => $category['color'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }
    }
}
