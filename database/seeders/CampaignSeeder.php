<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['id' => 1, 'code' => 'ar'],
            ['id' => 2, 'code' => 'en'],
        ];

        // --- CAMPAIGN 1: Brand Sale (Dell) ---
        $campaignId1 = DB::table('campaigns')->insertGetId([
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'campaignable_type' => 'brand', // Matches your MorphMap
            'campaignable_id' => 1, // Assuming Dell is ID 1
            'priority' => 10,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($languages as $lang) {
            DB::table('campaign_translations')->insert([
                'campaign_id' => $campaignId1,
                'language_id' => $lang['id'],
                'name' => $lang['code'] == 'en' ? 'Dell Summer Sale' : 'عروض ديل الصيفية',
                'description' => 'Discounts on Dell Laptops',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add 15% Discount to Campaign 1
        DB::table('discounts')->insert([
            'discountable_type' => 'campaign',
            'discountable_id' => $campaignId1,
            'type' => 'percentage',
            'value' => 15.00,
            'min_quantity' => 1,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // --- CAMPAIGN 2: Storewide Sale ---
        $campaignId2 = DB::table('campaigns')->insertGetId([
            'starts_at' => now(),
            'campaignable_type' => null, // NULL = Storewide
            'campaignable_id' => null,
            'priority' => 1,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($languages as $lang) {
            DB::table('campaign_translations')->insert([
                'campaign_id' => $campaignId2,
                'language_id' => $lang['id'],
                'name' => $lang['code'] == 'en' ? 'Welcome Discount' : 'خصم الترحيب',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add 500 EGP Fixed Discount to Campaign 2
        DB::table('discounts')->insert([
            'discountable_type' => 'campaign',
            'discountable_id' => $campaignId2,
            'type' => 'fixed',
            'value' => 500.00,
            'min_order_value' => 5000.00,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
