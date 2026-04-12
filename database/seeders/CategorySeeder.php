<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['مطاعم وكافيهات', 'أطباء وصيدليات', 'محال تجارية', 'مهن وحرف', 'مكاتب وشركات', 'مدارس ومعاهد', 'حلاقين وتجميل', 'كازيات وصيانة سيارات'];
        foreach ($categories as $cat) {
            \App\Models\Category::create(['name' => $cat]);
        }
    }
}
