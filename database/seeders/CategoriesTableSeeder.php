<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['cat one', 'cat two', 'cat three'];

        foreach ($categories as $category) {
            Category::create([
                'ar' => ['name' => $category],
                'en' => ['name' => $category],
            ]);
        }
    }
}
