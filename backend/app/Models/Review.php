<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_id',
        'booking_id',
        'rating',
        'comment',
    ];

    protected $casts = ['rating' => 'integer'];
}
