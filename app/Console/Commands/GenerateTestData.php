<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Saving;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateTestData extends Command
{
    protected $signature = 'app:generate-test-data';
    protected $description = 'Generate test data for development';

    public function handle(): void
    {
        $this->info('Generating test data...');

        // Create test users
        $students = collect();
        for ($i = 1; $i <= 10; $i++) {
            $students->push(User::factory()->create([
                'email' => sprintf('12220230%04d@mhs.dinus.ac.id', $i),
                'nim' => sprintf('A22.2023.%05d', $i),
                'role' => 'mahasiswa'
            ]));
        }

        $treasurer = User::factory()->create([
            'email' => '122202300011@mhs.dinus.ac.id',
            'nim' => 'A22.2023.00011',
            'role' => 'bendahara'
        ]);

        $committee = User::factory()->create([
            'email' => '122202300012@mhs.dinus.ac.id',
            'nim' => 'A22.2023.00012',
            'role' => 'panitia'
        ]);

        // Generate savings for past 12 weeks
        $startDate = now()->subWeeks(12);
        $students->each(function ($student) use ($startDate) {
            for ($week = 1; $week <= 12; $week++) {
                $date = $startDate->copy()->addWeeks($week - 1);

                // Random amount between 10k and 100k
                $amount = rand(1, 10) * 10000;

                Saving::factory()->create([
                    'user_id' => $student->id,
                    'amount' => $amount,
                    'week_number' => $week,
                    'created_at' => $date,
                    'status' => 'approved'
                ]);
            }
        });

        // Generate some expenses
        for ($i = 0; $i < 5; $i++) {
            $expense = Expense::factory()->create([
                'created_by' => $treasurer->id,
                'amount' => rand(5, 20) * 50000,
            ]);

            if (rand(0, 1)) {
                $expense->update([
                    'is_confirmed_by_other' => true,
                    'confirmed_by' => $committee->id,
                    'confirmed_at' => now()
                ]);
            }
        }

        $this->info('Test data generated successfully!');
    }
}
