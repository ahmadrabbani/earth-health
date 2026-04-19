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
       Schema::create('air_quality_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();

            $table->string('aqi_display')->nullable();
            $table->string('aqi_category')->nullable();
            $table->decimal('aqi_value', 8, 2)->nullable();

            $table->decimal('pm25', 8, 2)->nullable();
            $table->decimal('pm10', 8, 2)->nullable();
            $table->decimal('co', 8, 2)->nullable();
            $table->decimal('no2', 8, 2)->nullable();
            $table->decimal('o3', 8, 2)->nullable();
            $table->decimal('so2', 8, 2)->nullable();

            $table->json('health_recommendations')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('observed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_quality_snapshots');
    }
};
