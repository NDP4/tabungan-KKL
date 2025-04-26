<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\SavingRepositoryInterface;
use App\Repositories\SavingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SavingRepositoryInterface::class, SavingRepository::class);
    }
}
