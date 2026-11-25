<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear the table first to avoid duplicates
//        \App\Models\Language::truncate();

        $languages = [
            ['name' => 'Arabic', 'abbr' => 'ar', 'local' => 'ar', 'direction' => 'rtl', 'active' => 1],
            ['name' => 'English', 'abbr' => 'en', 'local' => 'en', 'direction' => 'ltr', 'active' => 1],
        ];

        foreach ($languages as $lang) {
            \App\Models\Language::create($lang);
        }
    }
}
