<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'location_id',
        'radius_m',
        'area_sq_m',
        'estimated_tree_cover_percent',
        'estimated_existing_trees',
        'estimated_tree_gap',
        'miyawaki_possible',
        'miyawaki_area_sq_m',
        'recommended_trees',
        'estimated_annual_carbon_kg',
        'green_score',
        'inputs',
        'calculation_breakdown',
    ];

    protected $casts = [
        'inputs' => 'array',
        'calculation_breakdown' => 'array',
        'miyawaki_possible' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function airQualitySnapshot()
    {
        return $this->hasOne(AirQualitySnapshot::class);
    }

    public function greeningScenarios()
    {
        return $this->hasMany(GreeningScenario::class);
    }

    public function aiRecommendation()
    {
        return $this->hasOne(AiRecommendation::class);
    }
}
