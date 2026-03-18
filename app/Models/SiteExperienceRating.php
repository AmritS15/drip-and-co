<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteExperienceRating extends Model
{
    protected $table = 'site_experience_ratings';

    protected $fillable = ['rating', 'user_id', 'session_id'];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
