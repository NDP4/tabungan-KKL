<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $studentNumber = str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);
        $email = '12220230' . $studentNumber . '@mhs.dinus.ac.id';
        $nim = 'A22.2023.' . $studentNumber;

        return [
            'name' => $this->faker->name(),
            'email' => $email,
            'nim' => $nim,
            'role' => $this->faker->randomElement(['mahasiswa', 'bendahara', 'panitia']),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function student(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'mahasiswa',
        ]);
    }

    public function treasurer(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'bendahara',
        ]);
    }

    public function committee(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'panitia',
        ]);
    }
}
