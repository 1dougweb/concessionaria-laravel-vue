<?php

namespace App\Domain\Sales\Providers;

use App\Domain\Sales\Repositories\SaleRepositoryContract;
use App\Infrastructure\Persistence\Eloquent\SaleRepository;
use Illuminate\Support\ServiceProvider;

class SalesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SaleRepositoryContract::class, SaleRepository::class);
    }
}

