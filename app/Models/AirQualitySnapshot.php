<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirQualitySnapshot extends Model
{
    protected $fillable = [
        'assessment_id',
        'aqi_display',
        'aqi_category',
        'aqi_value',
        'pm25',
        'pm10',
        'co',
        'no2',
        'o3',
        'so2',
        'health_recommendations',
        'raw_response',
        'observed_at',
    ];

    protected $casts = [
        'health_recommendations' => 'array',
        'raw_response' => 'array',
        'observed_at' => 'datetime',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
