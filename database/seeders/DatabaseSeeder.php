<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create bendahara account
        User::create([
            'name' => 'Bendahara KKL',
            'email' => '122202300001@mhs.dinus.ac.id',
            'nim' => 'A22.2023.00001',
            'password' => Hash::make('password'),
            'role' => 'bendahara',
            'email_verified_at' => now(),
        ]);

        // Create test student account
        User::create([
            'name' => 'Test Student',
            'email' => '122202300002@mhs.dinus.ac.id',
            'nim' => 'A22.2023.00002',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);
    }
}
