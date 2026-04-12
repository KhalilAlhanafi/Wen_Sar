<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            GovernorateSeeder::class,
            DistrictSeeder::class,
            SubAreaSeeder::class,
            CategorySeeder::class,
            BusinessSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@dalil.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');
    }
}
