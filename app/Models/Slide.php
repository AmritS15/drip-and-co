<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public const TYPE_HERO = 'hero';
    public const TYPE_STANDARD = 'standard';

    protected $fillable = [
        'type',
        'tagline',
        'title',
        'subtitle',
        'link',
        'link_right',
        'link_left_text',
        'link_right_text',
        'image',
        'image_right',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function isHero(): bool
    {
        return $this->type === self::TYPE_HERO;
    }
}
