<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use App\View\Components\FilamentDynamicComponent;
use App\Livewire\NotificationComponent;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::component('filament-dynamic', FilamentDynamicComponent::class);
        Livewire::component('notification-component', NotificationComponent::class);

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'components');
    }
}
