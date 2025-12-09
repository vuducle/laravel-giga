<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Review */
class ReviewResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'listing_id' => $this->listing_id,
            'booking_id' => $this->booking_id,
            'rating' => $this->rating,
            'commemt' => $this->commemt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
