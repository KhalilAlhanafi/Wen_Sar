<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = \App\Models\District::all();
        $subAreas = \App\Models\SubArea::all();
        $categories = \App\Models\Category::all();

        for ($i = 1; $i <= 100; $i++) {
            $cat = $categories->random();
            $area = $subAreas->random();
            
            \App\Models\Business::create([
                'name' => "محل رقم $i - " . $cat->name,
                'description' => "وصف تفصيلي للمحل رقم $i في منطقة " . $area->name,
                'district_id' => $area->district_id,
                'sub_area_id' => $area->id,
                'category_id' => $cat->id,
                'phone' => '0933' . rand(100000, 999999),
                'social_links' => [
                    'facebook' => 'https://facebook.com/business' . $i,
                    'instagram' => 'https://instagram.com/business' . $i,
                    'whatsapp' => '0933' . rand(100000, 999999),
                ],
                'views_count' => rand(10, 1000),
                'clicks_count' => rand(5, 500),
                'is_featured' => $i <= 10,
                'featured_rank' => $i <= 10 ? $i : null,
            ]);
        }
    }
}
