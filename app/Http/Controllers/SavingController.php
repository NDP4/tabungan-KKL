<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SetoranNotification;

class SavingController extends Controller
{
    // ...existing code...

    public function confirm(Saving $saving)
    {
        $saving->update([
            'status' => 'approved',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        // Send notification to user
        $saving->user->notify(new SetoranNotification(
            $saving,
            'approved',
            'Setoran anda sebesar Rp ' . number_format($saving->amount) . ' telah dikonfirmasi.'
        ));

        // Check weekly target and send notification if needed
        $weeklyTarget = 50000; // Set your weekly target here
        $weeklySavings = $saving->user->weeklySavings;
        if ($weeklySavings >= $weeklyTarget) {
            $saving->user->notify(new SetoranNotification(
                $saving,
                'weekly_target',
                'Selamat! Anda telah mencapai target mingguan sebesar Rp ' . number_format($weeklyTarget)
            ));
        }

        // Check progress and send notification
        $progress = $saving->user->progress;
        if ($progress % 25 == 0) { // Notify at every 25% progress
            $saving->user->notify(new SetoranNotification(
                $saving,
                'progress',
                'Selamat! Anda telah mencapai progress ' . number_format($progress) . '%'
            ));
        }

        return back()->with('success', 'Setoran berhasil dikonfirmasi');
    }

    public function reject(Saving $saving)
    {
        $saving->update([
            'status' => 'rejected',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        // Send notification to user
        $saving->user->notify(new SetoranNotification(
            $saving,
            'rejected',
            'Setoran anda sebesar Rp ' . number_format($saving->amount) . ' ditolak.'
        ));

        return back()->with('success', 'Setoran berhasil ditolak');
    }

    // ...existing code...
}
