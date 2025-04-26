<?php

namespace App\Actions;

use App\Models\Saving;
use App\Events\SavingStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

class ApproveSaving
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function execute(Saving $saving): bool
    {
        return DB::transaction(function () use ($saving) {
            $saving->update([
                'status' => 'approved',
                'confirmed_at' => now(),
            ]);

            $notificationService = app(NotificationService::class);
            $notificationService->notifySavingApproved($saving);

            $totalSavings = $saving->user->total_savings;
            $progress = $saving->user->progress;

            $notificationService->sendPaymentConfirmation($saving, $totalSavings, $progress);

            return true;
        });
    }
}
