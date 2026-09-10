<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstablishmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['restaurant', 'cafe']),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->randomElement(['Sabail', 'Nizami', 'Bayıl', 'Yasamal']),
            'mood' => $this->faker->randomElement(['romantik', 'sakin', 'canlı', 'lüks', 'bütçedostu']),
            'price_range' => $this->faker->numberBetween(1, 3),
            'image' => null,
            'latitude' => $this->faker->latitude(40.3, 40.5),
            'longitude' => $this->faker->longitude(49.7, 49.9),
            'rating' => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}
