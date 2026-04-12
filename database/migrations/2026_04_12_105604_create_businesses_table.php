<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_area_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->jsonb('social_links')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('clicks_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('featured_rank')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['district_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
