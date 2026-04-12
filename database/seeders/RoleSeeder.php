<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'guest']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'owner']);
        Role::create(['name' => 'admin']);
    }
}
