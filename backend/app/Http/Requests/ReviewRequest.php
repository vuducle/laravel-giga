<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required'],
            'listing_id' => ['required'],
            'booking_id' => ['required'],
            'rating' => ['required'],
            'commemt' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
