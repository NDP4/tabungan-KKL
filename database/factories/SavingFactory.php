<?php

namespace Database\Factories;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingFactory extends Factory
{
    protected $model = Saving::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(10000, 100000),
            'week_number' => $this->faker->numberBetween(1, 52),
            'payment_method' => $this->faker->randomElement(['transfer', 'tunai']),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'notes' => $this->faker->optional()->sentence(),
            'rejection_reason' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'rejected',
            'rejection_reason' => $this->faker->sentence(),
        ]);
    }

    public function transfer(): static
    {
        return $this->state(fn(array $attributes) => [
            'payment_method' => 'transfer',
            'proof_file' => 'proof_files/test.jpg',
        ]);
    }

    public function cash(): static
    {
        return $this->state(fn(array $attributes) => [
            'payment_method' => 'tunai',
        ]);
    }
}
