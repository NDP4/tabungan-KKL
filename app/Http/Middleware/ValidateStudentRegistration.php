<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateStudentRegistration
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') && $request->routeIs('register')) {
            $email = $request->input('email');
            $nim = $request->input('nim');

            // Validate email format (122202303004@mhs.dinus.ac.id)
            if (!preg_match('/^[0-9]{12}@mhs\.dinus\.ac\.id$/', $email)) {
                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Format email tidak valid. Gunakan email mahasiswa UDINUS.']);
            }

            // Validate NIM format (A22.2023.00001)
            if (!preg_match('/^A22\.2023\.[0-9]{5}$/', $nim)) {
                return back()
                    ->withInput()
                    ->withErrors(['nim' => 'Format NIM tidak valid. Gunakan format: A22.2023.XXXXX']);
            }

            // Extract and compare digits
            $emailDigits = substr($email, 8, 5); // Get 5 digits from email
            $nimDigits = substr($nim, -5); // Get last 5 digits from NIM

            if ($emailDigits !== $nimDigits) {
                return back()
                    ->withInput()
                    ->withErrors(['nim' => 'NIM tidak sesuai dengan email yang digunakan.']);
            }
        }

        return $next($request);
    }
}
