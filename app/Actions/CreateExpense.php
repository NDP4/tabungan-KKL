<?php

namespace App\Actions;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Traits\HandlesFileUploads;

class CreateExpense
{
    use HandlesFileUploads;

    public function execute(
        User $user,
        int $amount,
        string $description,
        ?UploadedFile $receipt = null,
        ?string $notes = null
    ): Expense {
        return DB::transaction(function () use ($user, $amount, $description, $receipt, $notes) {
            $expense = Expense::create([
                'created_by' => $user->id,
                'amount' => $amount,
                'description' => $description,
                'notes' => $notes
            ]);

            if ($receipt) {
                $expense->receipt_path = $this->uploadFile(
                    $receipt,
                    'expense-receipts'
                );
                $expense->save();
            }

            return $expense;
        });
    }
}
