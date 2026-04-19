<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiRecommendation extends Model
{
    protected $fillable = [
        'assessment_id',
        'model',
        'summary',
        'action_plan',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
