<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gov = \App\Models\Governorate::where('name', 'دمشق')->first();

        // Delete existing districts for Damascus
        \App\Models\District::where('governorate_id', $gov->id)->delete();

        $districts = [
            'مدينة دمشق',
            'المزة',
            'مشروع دمر',
            'أبو رمانة',
            'المالكي',
            'كفرسوسة',
            'المهاجرين',
            'الركن الدين',
            'الميدان',
            'الشعلان',
            'الصالحية',
            'الحمراء',
            'الروضة',
            'البرامكة',
            'المزرعة',
            'التجارة',
            'القصاع',
            'القصور',
            'العدوي',
            'باب توما',
            'باب شرقي',
            'القيمرية',
            'ساروجة',
            'العمارة',
            'دمشق القديمة',
            'دمشق الجديدة (قدسيا)',
            'جرمانا'
        ];

        foreach ($districts as $district) {
            \App\Models\District::create(['name' => $district, 'governorate_id' => $gov->id]);
        }
    }
}
