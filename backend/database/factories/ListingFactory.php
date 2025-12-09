<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'price_per_night' => $this->faker->word(),
            'max_guests' => $this->faker->randomNumber(),
            'bedrooms' => $this->faker->randomNumber(),
            'beds' => $this->faker->randomNumber(),
            'bathrooms' => $this->faker->randomNumber(),
            'amenities' => $this->faker->words(),
            'images' => $this->faker->words(),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
