<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $fakerAr = Faker::create('ar_SA');
        $categoryIds = Category::pluck('id')->toArray();
        $brandIds = Brand::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            try {
                DB::beginTransaction();

                // 1. Create instance (Matches Controller Step 1)
                $product = new Product([
                    'price' => $faker->randomFloat(2, 5000, 30000),
                    'brand_id' => $faker->randomElement($brandIds),
                    'quantity' => $faker->numberBetween(1, 10),
                    'active' => 1,
                    'category_id' => $faker->randomElement($categoryIds),
                    // We don't set 'photo' here because your logic does it later
                ]);

                // 2. Attach fake file to temp_photo (Matches Controller Step 2)
                $fakeImage = UploadedFile::fake()->image('laptop.jpg');
                $product->temp_photo = $fakeImage;

                // 3. Save (Matches Controller Step 3 - Triggers your Observer)
                // Since your observer doesn't 'return' a filename to the DB,
                // we manually set the filename here to ensure the record is valid.
                $product->photo = $fakeImage->hashName();
                $product->save();

                // 4. Create Translations (Matches Controller Step 4)
                $product->translations()->createMany([
                    [
                        'language_id' => 2,
                        'name' => 'Laptop ' . $faker->word . ' ' . $i,
                        'slug' => Str::slug($faker->word . $i),
                        'description' => $faker->paragraph,
                    ],
                    [
                        'language_id' => 1,
                        'name' => 'لابتوب ' . $i,
                        'slug' => 'لابتوب-' . $i,
                        'description' => $fakerAr->paragraph,
                    ]
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Output error to console so you know why it failed
                $this->command->error("Product $i failed: " . $e->getMessage());
            }
        }
    }
}
