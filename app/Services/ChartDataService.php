<?php

namespace App\Services;

use App\Models\Saving;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ChartDataService
{
    public function getSavingsChartData(?int $userId = null): array
    {
        $query = Saving::query()
            ->where('status', 'approved')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->orderBy('created_at');

        $savings = $query->get()
            ->groupBy(fn($saving) => $saving->created_at->format('Y-m-d'))
            ->map(fn($group) => $group->sum('amount'));

        $cumulativeSum = 0;
        $data = $savings->map(function ($amount) use (&$cumulativeSum) {
            $cumulativeSum += $amount;
            return $cumulativeSum;
        });

        return [
            'labels' => $data->keys()->toArray(),
            'values' => $data->values()->toArray(),
        ];
    }

    public function getWeeklySavingsData(?int $userId = null): array
    {
        $query = Saving::query()
            ->where('status', 'approved')
            ->when($userId, fn($q) => $q->where('user_id', $userId));

        $weeklySavings = $query->get()
            ->groupBy('week_number')
            ->map(fn($group) => $group->sum('amount'));

        return [
            'labels' => $weeklySavings->keys()->map(fn($week) => "Minggu {$week}")->toArray(),
            'values' => $weeklySavings->values()->toArray(),
        ];
    }

    public function getProgressByStudent(): array
    {
        $savings = Saving::with('user')
            ->where('status', 'approved')
            ->get()
            ->groupBy('user_id')
            ->map(function ($userSavings) {
                $total = $userSavings->sum('amount');
                $progress = min(($total / 1950000) * 100, 100);
                $user = $userSavings->first()->user;

                return [
                    'name' => $user->name,
                    'nim' => $user->nim,
                    'total' => $total,
                    'progress' => $progress,
                ];
            })
            ->sortByDesc('progress')
            ->values();

        return [
            'labels' => $savings->pluck('name')->toArray(),
            'values' => $savings->pluck('progress')->toArray(),
            'details' => $savings->toArray(),
        ];
    }
}
