<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_featured');
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->timestamp('contract_ends_at')->nullable()->after('approved_at');
            $table->integer('contract_duration_days')->nullable()->after('contract_ends_at');
            $table->foreignId('approved_by')->nullable()->constrained('managers')->nullOnDelete()->after('contract_duration_days');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'approved_at', 'contract_ends_at', 'contract_duration_days', 'approved_by']);
        });
    }
};
