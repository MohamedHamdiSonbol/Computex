<?php
namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
//    public function run(): void
//    {
//        $languages = [
//            ['id' => 1, 'code' => 'ar'],
//            ['id' => 2, 'code' => 'en'],
//        ];
//
//        $brandNames = ['Dell', 'HP', 'Lenovo', 'Apple', 'Asus'];
//
//        foreach ($brandNames as $index => $name) {
//            // 1. Insert the Main Brand
//            $brandId = DB::table('brands')->insertGetId([
//                'logo' => strtolower($name) . '.png',
//                'is_active' => 1,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//
//
//
//
//            // 2. Insert Translations
//            foreach ($languages as $lang) {
//                DB::table('brand_translations')->insert([
//                    'brand_id' => $brandId,
//                    'language_id' => $lang['id'],
//                    'name' => ($lang['code'] == 'ar' ? 'ماركة ' : '') . $name,
//                    'slug' => Str::slug($name) . '-' . $lang['code'],
//                    'created_at' => now(),
//                    'updated_at' => now(),
//                ]);
//            }
//        }
//    }


    public function run(): void
    {
        $languages = [1, 2]; // Assuming IDs for ar and en
        $brandNames = ['Dell', 'HP', 'Lenovo', 'Apple', 'Asus'];

        foreach ($brandNames as $name) {
            // 1. Create a fake image file
            $fakeLogo = UploadedFile::fake()->image(strtolower($name) . '.png');

            // 2. Instantiate the Model (This triggers your upload logic if in Observer/Mutator)
            $brand = new Brand();
            $brand->is_active = 1;

            // Assign the file to the attribute your model expects
            // Note: Ensure your Brand model has 'logo' in $fillable
            $brand->temp_photo = $fakeLogo;
            $brand->logo = $fakeLogo->hashName();
            $brand->save();

            // 3. Insert Translations using the Relationship
            foreach ($languages as $langId) {
                $brand->translations()->create([
                    'language_id' => $langId,
                    'name' => ($langId == 1 ? 'ماركة ' : '') . $name,
                    'slug' => Str::slug($name) . '-' . ($langId == 1 ? 'ar' : 'en'),
                ]);
            }
        }
    }
}
