<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'avatar_url' => $this->faker->imageUrl(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'country' => $this->faker->country(),
            'state' => $this->faker->state(),
            'city' => $this->faker->city(),
            'zip_code' => $this->faker->postcode(),
            'company' => $this->faker->company(),
            'is_verified' => true,
            'is_public' => true,
            'about' => $this->faker->text(),
            'status' => $this->faker->randomElement(['active', 'banned']),
            'role_id' => $this->faker->numberBetween(1, 3),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Change 'password' to your desired default password
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
