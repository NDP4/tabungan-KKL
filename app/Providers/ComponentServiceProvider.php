<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\FilamentDynamicComponent;
use App\Services\ComponentResolver;

class ComponentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ComponentResolver::class);
    }

    public function boot(): void
    {
        Blade::component('filament-dynamic', FilamentDynamicComponent::class);
    }
}
