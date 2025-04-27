<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['hd' => 'mhs.dinus.ac.id'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Verify email domain
            if (!str_ends_with($googleUser->email, '@mhs.dinus.ac.id')) {
                return redirect()->route('login')
                    ->with('error', 'Hanya email mahasiswa UDINUS (@mhs.dinus.ac.id) yang diperbolehkan.');
            }

            // Extract NIM from email (122202303001@mhs.dinus.ac.id -> A22.2023.03001)
            $emailPrefix = explode('@', $googleUser->email)[0];
            $angkatan = substr($emailPrefix, 1, 2); // 22
            $tahun = substr($emailPrefix, 3, 4); // 2023
            $nim = sprintf(
                'A%s.%s.%s',
                $angkatan,
                $tahun,
                substr($emailPrefix, -5)
            );

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'nim' => $nim,
                    'password' => Hash::make(str()->random(16)),
                    'role' => 'mahasiswa',
                    'email_verified_at' => now(), // Auto verify since it's Google OAuth
                ]);
            }

            Auth::login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal melakukan autentikasi dengan Google. Silakan coba lagi.');
        }
    }
}
