<?php

namespace App\Repositories\Contracts;

use App\Models\Saving;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface SavingRepositoryInterface
{
    public function createSaving(User $user, array $data): Saving;
    public function approveSaving(Saving $saving): bool;
    public function rejectSaving(Saving $saving, string $reason): bool;
    public function getUserWeeklySavings(User $user): float;
    public function getUserTotalSavings(User $user): float;
    public function getPendingSavings(): Collection;
    public function getSavingsByStatus(string $status): Collection;
    public function getRecentSavings(int $limit = 10): Collection;
    public function uploadProofFile(Saving $saving, $file): bool;
    public function getSavingsByDateRange(Carbon $startDate, Carbon $endDate): Collection;
}
