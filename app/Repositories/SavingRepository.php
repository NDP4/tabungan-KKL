<?php

namespace App\Repositories;

use App\Models\Saving;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SavingRepository
{
    public function createSaving(User $user, array $data): Saving
    {
        return $user->savings()->create([
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'week_number' => $this->calculateWeekNumber(),
            'notes' => $data['notes'] ?? null,
            'proof_file' => $data['proof_file'] ?? null,
            'status' => 'pending'
        ]);
    }

    public function approveSaving(Saving $saving): bool
    {
        return $saving->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);
    }

    public function rejectSaving(Saving $saving, string $reason): bool
    {
        return $saving->update([
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }

    public function getUserWeeklySavings(User $user): float
    {
        return $user->savings()
            ->where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->startOfWeek())
            ->sum('amount');
    }

    public function getUserTotalSavings(User $user): float
    {
        return $user->savings()
            ->where('status', 'approved')
            ->sum('amount');
    }

    public function getPendingSavings(): Collection
    {
        return Saving::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function getSavingsByStatus(string $status): Collection
    {
        return Saving::with('user')
            ->where('status', $status)
            ->latest()
            ->get();
    }

    public function getRecentSavings(int $limit = 10): Collection
    {
        return Saving::with('user')
            ->where('status', 'approved')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function uploadProofFile(Saving $saving, $file): bool
    {
        $path = $file->store('proof_files', 'public');
        return $saving->update(['proof_file' => $path]);
    }

    public function getSavingsByDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return Saving::with('user')
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    private function calculateWeekNumber(): int
    {
        $startDate = Carbon::parse(config('app.start_date', '2024-01-01'));
        return Carbon::now()->diffInWeeks($startDate) + 1;
    }
}
