<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition():array
    {
        return [
            'user_id' => $this->faker->word(),
            'listing_id' => $this->faker->word(),
            'check_in' => Carbon::now(),
            'check_out' => Carbon::now(),
            'guests' => $this->faker->randomNumber(),
            'total_price' => $this->faker->randomFloat(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
