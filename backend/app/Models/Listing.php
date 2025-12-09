<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'title',
        'description',
        'address',
        'city',
        'price_per_night',
        'max_guests',
        'bedrooms',
        'beds',
        'bathrooms',
        'amenities',
        'images',
        'is_active'
    ];
    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
            'max_guests' => 'integer',
            'bedrooms' => 'integer',
            'beds' => 'integer',
            'bathrooms' => 'integer',
            'is_active' => 'boolean',
            'amenities' => 'array',
            'images' => 'array',

        ];
    }
}
