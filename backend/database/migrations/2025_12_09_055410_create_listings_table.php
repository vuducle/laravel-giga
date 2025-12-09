<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('address');
            $table->string('city');
            $table->decimal('price_per_night');
            $table->integer('max_guests');
            $table->integer('bedrooms');
            $table->integer('beds');
            $table->integer('bathrooms');
            $table->string('amenities');
            $table->string('images');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listings');
    }
};
