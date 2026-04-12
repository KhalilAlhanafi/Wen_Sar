<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $district = \App\Models\District::where('name', 'مدينة دمشق')->first();
        $areas = ['المالكي', 'أبو رمانة', 'المزة', 'مشروع دمر', 'القصاع', 'باب توما', 'الشعلان', 'الميدان', 'كفرسوسة'];
        foreach ($areas as $area) {
            \App\Models\SubArea::create(['name' => $area, 'district_id' => $district->id]);
        }
    }
}
