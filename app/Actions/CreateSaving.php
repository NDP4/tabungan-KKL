<?php

namespace App\Actions;

use App\Models\Saving;
use App\Models\User;
use App\Events\SavingStatusUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Traits\HandlesFileUploads;

class CreateSaving
{
    use HandlesFileUploads;

    public function execute(
        User $user,
        int $amount,
        string $paymentMethod,
        ?UploadedFile $proofOfPayment = null,
        ?string $notes = null
    ): Saving {
        return DB::transaction(function () use ($user, $amount, $paymentMethod, $proofOfPayment, $notes) {
            $weekNumber = now()->diffInWeeks(config('kkl.start_date')) + 1;

            $saving = Saving::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'week_number' => $weekNumber,
                'notes' => $notes,
                'status' => $user->role === 'bendahara' ? 'approved' : 'pending'
            ]);

            if ($proofOfPayment) {
                $saving->proof_of_payment = $this->uploadFile(
                    $proofOfPayment,
                    'proof-of-payments'
                );
                $saving->save();
            }

            event(new SavingStatusUpdated($saving));

            return $saving;
        });
    }
}
