<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $languages = [
            ['id' => 1, 'code' => 'en', 'suffix' => ' (عربي)'],
            ['id' => 2, 'code' => 'ar', 'suffix' => ' (EN)'],
        ];

        for ($i = 1; $i <= 10; $i++) {
            // 1. Create the Main Category
            $categoryId = DB::table('categories')->insertGetId([
//                'photo' => 'category-' . $i . '.png',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Create Translations for this Category
            foreach ($languages as $lang) {
                $name = "Category " . $i . $lang['suffix'];

                DB::table('category_translations')->insert([
                    'category_id' => $categoryId,
                    'language_id' => $lang['id'],
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => "This is a description for Category $i in " . $lang['code'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
}
}
