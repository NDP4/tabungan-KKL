<?php

namespace App\Actions;

use App\Models\Saving;
use App\Events\SavingStatusUpdated;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

class RejectSaving
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function execute(Saving $saving, string $reason): bool
    {
        return DB::transaction(function () use ($saving, $reason) {
            $saving->update([
                'status' => 'rejected',
                'rejection_reason' => $reason,
                'rejected_at' => now(),
            ]);

            event(new SavingStatusUpdated($saving));

            $this->notificationService->notifySavingRejected($saving, $reason);

            return true;
        });
    }
}
