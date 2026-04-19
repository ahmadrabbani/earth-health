<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreeningScenario extends Model
{
    protected $fillable = [
        'assessment_id',
        'scenario_type',
        'additional_trees',
        'forest_area_sq_m',
        'projected_annual_carbon_kg',
        'projected_canopy_gain_percent',
        'projected_green_score',
        'notes',
    ];

    protected $casts = [
        'notes' => 'array',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
