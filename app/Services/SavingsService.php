<?php

namespace App\Services;

use App\Models\User;
use App\Models\Saving;
use Carbon\{Carbon, CarbonInterface};

class SavingsService
{
    public const TARGET_AMOUNT = 1950000;
    public const WEEKLY_TARGET = 10000;
    private const PROGRAM_START = '2025-05-01'; // May 1, 2025 as program start date
    private const WEEK_TWO_START = '2025-05-06';  // Monday 00:00 after May 1

    protected function getStartDate(): Carbon
    {
        return Carbon::create(2025, 5, 1, 0, 0, 0); // May 1, 2025 00:00:00
    }

    public function calculateWeekNumber(): int
    {
        $startDate = Carbon::parse(self::PROGRAM_START);
        $now = Carbon::now();

        // If current date is before program start, return -1
        if ($now->lt($startDate)) {
            return -1;
        }

        // If we're in the first week (May 1-5)
        $weekTwoStart = Carbon::parse(self::WEEK_TWO_START);
        if ($now->lt($weekTwoStart)) {
            return 1;
        }

        // For dates after first week, calculate based on Week 2 start
        return $now->diffInWeeks($weekTwoStart) + 2;
    }

    public function hasMetWeeklyTarget(User $user): bool
    {
        // If we're in week -1, no target to meet
        if ($this->calculateWeekNumber() === -1) {
            return false;
        }

        $weekStart = Carbon::now()->startOfWeek();
        $weeklyTotal = $user->savings()
            ->where('status', 'approved')
            ->where('created_at', '>=', $weekStart)
            ->sum('amount');

        return $weeklyTotal >= $this->getWeeklyTarget();
    }

    public function hasMetTotalTarget(User $user): bool
    {
        $totalSavings = $user->savings()
            ->where('status', 'approved')
            ->sum('amount');

        return $totalSavings >= config('kkl.target_amount');
    }

    public function hasConsistentWeeklySavings(User $user): bool
    {
        $startDate = $this->getStartDate();
        $totalWeeks = Carbon::now()->diffInWeeks($startDate) + 1;

        $weeksWithSavings = $user->savings()
            ->where('status', 'approved')
            ->where('amount', '>=', self::WEEKLY_TARGET)
            ->distinct('week_number')
            ->count();

        return $weeksWithSavings >= $totalWeeks;
    }

    public function getProgressSummary(User $user): array
    {
        $totalSavings = $user->savings()
            ->where('status', 'approved')
            ->sum('amount');

        $weekStart = Carbon::now()->startOfWeek();
        $weeklySavings = $user->savings()
            ->where('status', 'approved')
            ->where('created_at', '>=', $weekStart)
            ->sum('amount');

        return [
            'total_savings' => $totalSavings,
            'weekly_savings' => $weeklySavings,
            'total_progress' => min(($totalSavings / config('kkl.target_amount')) * 100, 100),
            'weekly_progress' => min(($weeklySavings / $this->getWeeklyTarget()) * 100, 100),
            'target_completed' => $this->hasMetTotalTarget($user),
            'weekly_target_met' => $this->hasMetWeeklyTarget($user),
            'is_consistent' => $this->hasConsistentWeeklySavings($user),
        ];
    }

    public function validateWeeklySavings(User $user, float $amount): bool
    {
        $weekStart = Carbon::now()->startOfWeek();
        $existingSavings = $user->savings()
            ->where('status', 'approved')
            ->where('created_at', '>=', $weekStart)
            ->sum('amount');

        return ($existingSavings + $amount) >= self::WEEKLY_TARGET;
    }

    public function getTotalSavings(User $user): int
    {
        return $user->savings()
            ->where('status', 'approved')
            ->sum('amount');
    }

    public function getWeeklySavings(User $user): int
    {
        return $user->savings()
            ->where('status', 'approved')
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->sum('amount');
    }

    public function calculateProgress(User $user): float
    {
        $totalSaved = $this->getTotalSavings($user);
        $target = config('kkl.target_amount');

        return ($totalSaved / $target) * 100;
    }

    public function getClassProgress(): array
    {
        $target = config('kkl.target_amount');
        $totalClassSavings = Saving::where('status', 'approved')->sum('amount');
        $totalStudents = User::where('role', 'mahasiswa')->count();
        $targetClassTotal = $target * $totalStudents;

        return [
            'total_savings' => $totalClassSavings,
            'target_amount' => $targetClassTotal,
            'progress_percentage' => ($totalClassSavings / $targetClassTotal) * 100,
            'total_students' => $totalStudents
        ];
    }

    public function getStudentRankings(): array
    {
        return User::where('role', 'mahasiswa')
            ->withSum(['savings' => fn($query) => $query->where('status', 'approved')], 'amount')
            ->orderByDesc('savings_sum_amount')
            ->get()
            ->map(fn($user) => [
                'name' => $user->name,
                'total_saved' => $user->savings_sum_amount ?? 0,
                'progress' => $this->calculateProgress($user)
            ])
            ->toArray();
    }

    public function getWeeklyStats(): array
    {
        $startDate = Carbon::parse(config('kkl.start_date'));
        $currentWeek = now()->diffInWeeks($startDate) + 1;

        $weeklyData = collect(range(1, $currentWeek))->map(function ($weekNumber) use ($startDate) {
            $weekStart = $startDate->copy()->addWeeks($weekNumber - 1);
            $weekEnd = $weekStart->copy()->endOfWeek();

            $savings = Saving::where('status', 'approved')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            return [
                'week' => $weekNumber,
                'total_savings' => $savings,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekEnd->format('Y-m-d')
            ];
        });

        return $weeklyData->toArray();
    }

    public function getWeeklyTarget(): float
    {
        return (float) config('kkl.weekly_target', self::WEEKLY_TARGET);
    }

    public function getWeeklySavingsData(): array
    {
        $startDate = $this->getStartDate();
        $currentWeek = $this->calculateWeekNumber();

        if ($currentWeek <= 0) {
            return [];
        }

        $weeklyData = collect(range(1, $currentWeek))->map(function ($weekNumber) use ($startDate) {
            if ($weekNumber === 1) {
                // First week is from start date to Sunday
                $weekStart = $startDate;
                $weekEnd = $startDate->copy()->next(Carbon::SUNDAY);
            } else {
                // Subsequent weeks are Monday to Sunday
                $firstMonday = $startDate->copy()->next(Carbon::MONDAY);
                $weekStart = $firstMonday->copy()->addWeeks($weekNumber - 2);
                $weekEnd = $weekStart->copy()->endOfWeek();
            }

            $savings = Saving::where('status', 'approved')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            return [
                'week' => $weekNumber,
                'total_savings' => $savings,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekEnd->format('Y-m-d')
            ];
        });

        return $weeklyData->toArray();
    }

    public function getWeekRange(int $weekNumber = null): array
    {
        $startDate = Carbon::parse(self::PROGRAM_START);
        $now = Carbon::now();

        // If no week number provided, calculate current week
        if ($weekNumber === null) {
            if ($now->lt($startDate)) {
                return [
                    'start' => $now->format('Y-m-d'),
                    'end' => $now->format('Y-m-d'),
                    'week_number' => -1
                ];
            }
            $weekNumber = $this->calculateWeekNumber();
        }

        // Handle pre-program period
        if ($weekNumber === -1) {
            return [
                'start' => null,
                'end' => Carbon::parse(self::PROGRAM_START)->subDay(),
            ];
        }

        // Handle first week (special case)
        if ($weekNumber === 1) {
            return [
                'start' => Carbon::parse(self::PROGRAM_START),
                'end' => Carbon::parse(self::WEEK_TWO_START)->subDay(),
            ];
        }

        // Handle week 2 onwards
        $weekTwoStart = Carbon::parse(self::WEEK_TWO_START);
        $start = $weekTwoStart->copy()->addWeeks($weekNumber - 2);

        return [
            'start' => $start,
            'end' => $start->copy()->addDays(6),
            'week_number' => $weekNumber
        ];
    }

    public function getWeeklyData(): array
    {
        $startDate = Carbon::parse('2025-05-01');
        $currentWeek = $this->calculateWeekNumber();

        // If we're before the program starts, return empty array
        if ($currentWeek === -1) {
            return [];
        }

        $weeklyData = collect(range(1, $currentWeek))->map(function ($weekNumber) use ($startDate) {
            // Special handling for week 1 (May 1-3, 2025)
            if ($weekNumber === 1) {
                $weekStart = $startDate;
                $weekEnd = Carbon::parse('2025-05-03')->endOfDay();
            } else {
                // For week 2 onwards, start from Monday May 4
                $weekStart = Carbon::parse('2025-05-04')->addWeeks($weekNumber - 2);
                $weekEnd = $weekStart->copy()->endOfWeek();
            }

            $savings = Saving::where('status', 'approved')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            return [
                'week' => $weekNumber,
                'total_savings' => $savings,
                'start_date' => $weekStart->format('Y-m-d'),
                'end_date' => $weekEnd->format('Y-m-d')
            ];
        });

        return $weeklyData->toArray();
    }
}
