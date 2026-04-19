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
        Schema::create('greening_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();

            $table->string('scenario_type')->default('trees'); // trees, miyawaki
            $table->integer('additional_trees')->default(0);
            $table->decimal('forest_area_sq_m', 12, 2)->nullable();

            $table->decimal('projected_annual_carbon_kg', 12, 2)->nullable();
            $table->decimal('projected_canopy_gain_percent', 5, 2)->nullable();
            $table->decimal('projected_green_score', 5, 2)->nullable();

            $table->json('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greening_scenarios');
    }
};
