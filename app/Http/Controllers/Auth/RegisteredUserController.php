<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class,
                'regex:/^[0-9]{12}@mhs\.dinus\.ac\.id$/',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.regex' => 'Email harus menggunakan format email mahasiswa UDINUS (contoh: 122202303001@mhs.dinus.ac.id).'
        ]);

        // Extract NIM from email (122202303001@mhs.dinus.ac.id -> A22.2023.03001)
        $emailPrefix = explode('@', $request->email)[0];
        $angkatan = substr($emailPrefix, 1, 2); // 22
        $tahun = substr($emailPrefix, 3, 4); // 2023
        $nim = sprintf(
            'A%s.%s.%s',
            $angkatan,
            $tahun,
            substr($emailPrefix, -5)
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Send verification email immediately
        $user->sendEmailVerificationNotification();

        return redirect(route('verification.notice'))->with('status', 'verification-link-sent');
    }
}
