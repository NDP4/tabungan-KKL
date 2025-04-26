<?php

return [
    /*
    |--------------------------------------------------------------------------
    | KKL Start Date
    |--------------------------------------------------------------------------
    |
    | This value determines the start date of the KKL savings period.
    | This is used to calculate week numbers and progress.
    |
    */
    'start_date' => env('KKL_START_DATE', '2025-05-01'),

    /*
    |--------------------------------------------------------------------------
    | Target Amount
    |--------------------------------------------------------------------------
    |
    | The target amount each student needs to save for KKL.
    |
    */
    'target_amount' => env('KKL_TARGET_AMOUNT', 1950000),

    /*
    |--------------------------------------------------------------------------
    | Weekly Target
    |--------------------------------------------------------------------------
    |
    | The recommended weekly savings amount to reach the target.
    |
    */
    'weekly_target' => env('KKL_WEEKLY_TARGET', 50000),

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    |
    | Available payment methods for savings.
    |
    */
    'payment_methods' => [
        'transfer' => [
            'name' => 'Transfer Bank',
            'requires_proof' => true,
        ],
        'tunai' => [
            'name' => 'Tunai',
            'requires_proof' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reminder Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for weekly payment reminders.
    |
    */
    'reminders' => [
        'enabled' => env('KKL_REMINDERS_ENABLED', true),
        'day' => env('KKL_REMINDER_DAY', 'Monday'),
        'time' => env('KKL_REMINDER_TIME', '09:00'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Bank Account Details
    |--------------------------------------------------------------------------
    |
    | Bank account information for transfers.
    |
    */
    'bank_account' => [
        'name' => env('KKL_BANK_ACCOUNT_NAME', 'Bendahara KKL'),
        'number' => env('KKL_BANK_ACCOUNT_NUMBER', '1234567890'),
        'bank' => env('KKL_BANK_NAME', 'BCA'),
    ],
];
