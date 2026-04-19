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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->integer('radius_m')->default(500);
            $table->decimal('area_sq_m', 12, 2)->nullable();

            $table->decimal('estimated_tree_cover_percent', 5, 2)->nullable();
            $table->integer('estimated_existing_trees')->nullable();
            $table->integer('estimated_tree_gap')->nullable();

            $table->boolean('miyawaki_possible')->default(false);
            $table->decimal('miyawaki_area_sq_m', 12, 2)->nullable();
            $table->integer('recommended_trees')->nullable();

            $table->decimal('estimated_annual_carbon_kg', 12, 2)->nullable();
            $table->decimal('green_score', 5, 2)->nullable();

            $table->json('inputs')->nullable();
            $table->json('calculation_breakdown')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
