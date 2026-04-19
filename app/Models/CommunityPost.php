<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'auth0_user_id',
        'author_name',
        'author_email',
        'title',
        'location_name',
        'body',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(CommunityComment::class)->latest();
    }
}
