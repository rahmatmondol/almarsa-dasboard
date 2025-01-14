<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banner_background',
        'banner_title',
        'banner_image',
        'email',
        'phone',
        'address',
        'about',
        'title',
        'sub_title',
        'icons',
        'image_cards',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'icons' => 'array',
        'image_cards' => 'array',
    ];
}
