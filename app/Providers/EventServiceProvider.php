<?php

namespace App\Providers;

use App\Events\SavingStatusUpdated;
use App\Events\ExpenseConfirmed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SavingStatusUpdated::class => [
            // Add listeners here
        ],
        ExpenseConfirmed::class => [
            // Add listeners here
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UpdateUserLastLogin',
        ],
    ];

    public function boot(): void
    {
        //
    }
}
