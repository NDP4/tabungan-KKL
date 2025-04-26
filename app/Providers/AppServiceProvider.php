<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\FilamentDynamicComponent;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::component('filament-dynamic', FilamentDynamicComponent::class);

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'components');
    }
}
