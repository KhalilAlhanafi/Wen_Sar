<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear all data tables (preserve managers if you want to keep login access)
        $tables = [
            'favorites',
            'reviews',
            'businesses',
            'sub_areas',
            'districts',
            'governorates',
            'categories',
            'users', // Remove if you want to keep user accounts
            // Keep managers table so you can still log in
            // 'managers',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Truncated table: {$table}");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Database cleared successfully! You can now add data from the manager dashboard.');
        $this->command->warn('Note: Manager accounts were preserved so you can still log in.');
    }
}
