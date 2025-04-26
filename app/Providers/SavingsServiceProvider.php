<?php

namespace App\Providers;

use App\Services\SavingsService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class SavingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SavingsService::class, function ($app) {
            return new SavingsService();
        });
    }

    public function boot(): void
    {
        // Set environment variables
        config([
            'app.start_date' => '2024-01-01',
            'app.target_amount' => 1950000,
            'app.weekly_target' => 10000,
            'app.treasurer_whatsapp' => '6285866233841',
        ]);

        // Register custom validation rules
        Validator::extend('valid_student_email', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{12}@mhs\.dinus\.ac\.id$/', $value);
        });

        Validator::extend('valid_student_nim', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^A22\.2023\.[0-9]{5}$/', $value);
        });
    }
}
