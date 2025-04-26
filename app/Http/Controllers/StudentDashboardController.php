<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalSavings = $user->total_savings;
        $weeklySavings = $user->weekly_savings;
        $totalParticipants = \App\Models\User::count();
        $totalClassSavings = \App\Models\Saving::where('status', 'approved')->sum('amount');
        $totalExpenses = Expense::where('is_confirmed_by_other', true)->sum('amount');

        $savings = $user->savings()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $progressPercentage = min(($totalSavings / 1950000) * 100, 100);
        $weeklyProgressPercentage = min(($weeklySavings / 10000) * 100, 100);

        return view('dashboard', compact(
            'totalSavings',
            'weeklySavings',
            'totalParticipants',
            'totalExpenses',
            'totalClassSavings',
            'savings',
            'progressPercentage',
            'weeklyProgressPercentage'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:transfer,tunai',
            'proof_file' => 'required_if:payment_method,transfer|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:255'
        ], [
            'amount.required' => 'Jumlah setoran wajib diisi',
            'amount.numeric' => 'Jumlah setoran harus berupa angka',
            'amount.min' => 'Jumlah setoran minimal Rp 1.000',
            'payment_method.required' => 'Metode pembayaran wajib dipilih',
            'payment_method.in' => 'Metode pembayaran tidak valid',
            'proof_file.required_if' => 'Bukti transfer wajib diunggah untuk pembayaran via transfer',
            'proof_file.file' => 'Bukti transfer harus berupa file',
            'proof_file.mimes' => 'Bukti transfer harus berupa file gambar (JPG, JPEG, PNG) atau PDF',
            'proof_file.max' => 'Ukuran bukti transfer maksimal 2MB',
        ]);

        $saving = new Saving();
        $saving->user_id = auth()->id();
        $saving->amount = $validated['amount'];
        $saving->payment_method = $validated['payment_method'];
        $saving->week_number = Saving::calculateWeekNumber();
        $saving->notes = $validated['notes'];

        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('proof_files', 'public');
            $saving->proof_file = $path;
        }

        $saving->save();

        if ($saving->payment_method === 'transfer') {
            return redirect()->route('savings.confirm', $saving);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Setoran berhasil disimpan dan menunggu konfirmasi bendahara.');
    }

    public function confirm(Saving $saving)
    {
        if ($saving->user_id !== auth()->id()) {
            abort(403);
        }

        return view('savings.confirm', compact('saving'));
    }

    public function downloadReceipt(Saving $saving)
    {
        if ($saving->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = PDF::loadView('pdf.receipt', compact('saving'));

        return $pdf->download('bukti-pembayaran-' . $saving->id . '.pdf');
    }

    public function cancel(Saving $saving)
    {
        if ($saving->user_id !== auth()->id()) {
            abort(403);
        }

        if ($saving->status !== 'pending') {
            return back()->with('error', 'Hanya setoran dengan status menunggu yang dapat dibatalkan.');
        }

        $saving->update([
            'status' => 'rejected',
            'rejection_reason' => 'Dibatalkan oleh mahasiswa'
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Setoran berhasil dibatalkan.');
    }

    public function delete(Saving $saving)
    {
        if ($saving->user_id !== auth()->id()) {
            abort(403);
        }

        if ($saving->status !== 'rejected') {
            return back()->with('error', 'Hanya setoran yang ditolak yang dapat dihapus.');
        }

        if ($saving->payment_method === 'transfer' && $saving->proof_file) {
            Storage::disk('public')->delete($saving->proof_file);
        }

        $saving->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Setoran berhasil dihapus dari riwayat.');
    }
}
