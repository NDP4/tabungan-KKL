<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->numberBetween(50000, 500000),
            'created_by' => User::factory()->treasurer(),
            'is_confirmed_by_other' => false,
            'confirmed_by' => null,
            'confirmed_at' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(function (array $attributes) {
            $confirmer = User::factory()->committee()->create();

            return [
                'is_confirmed_by_other' => true,
                'confirmed_by' => $confirmer->id,
                'confirmed_at' => now(),
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_confirmed_by_other' => false,
            'confirmed_by' => null,
            'confirmed_at' => null,
        ]);
    }
}
