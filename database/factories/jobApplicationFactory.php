<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class jobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone_no'=>fake()->unique()->e164PhoneNumber(),
                'capta_code' => Str::random(10),
                'resume'=>fake()->name(),
            ];
       
    }
}
