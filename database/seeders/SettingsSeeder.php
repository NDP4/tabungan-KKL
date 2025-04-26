<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Target Settings
            [
                'group' => 'target',
                'key' => 'total_target',
                'value' => '1950000'
            ],
            [
                'group' => 'target',
                'key' => 'weekly_target',
                'value' => '10000'
            ],

            // Payment Settings
            [
                'group' => 'payment',
                'key' => 'bank_name',
                'value' => 'BRI'
            ],
            [
                'group' => 'payment',
                'key' => 'account_number',
                'value' => '1234567890'
            ],
            [
                'group' => 'payment',
                'key' => 'account_holder',
                'value' => 'BENDAHARA KKL'
            ],

            // Website Settings
            [
                'group' => 'website',
                'key' => 'site_name',
                'value' => 'Tabungan KKL'
            ],
            [
                'group' => 'website',
                'key' => 'site_description',
                'value' => 'Sistem Tabungan KKL'
            ],

            // Contact Settings
            [
                'group' => 'contact',
                'key' => 'admin_phone',
                'value' => '6281234567890'
            ],
            [
                'group' => 'contact',
                'key' => 'admin_email',
                'value' => 'admin@example.com'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
