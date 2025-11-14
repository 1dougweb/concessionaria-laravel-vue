<?php

namespace App\Domain\Vehicles\Providers;

use App\Domain\Vehicles\Repositories\VehicleRepositoryContract;
use App\Infrastructure\Persistence\Eloquent\VehicleRepository;
use Illuminate\Support\ServiceProvider;

class VehiclesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(VehicleRepositoryContract::class, VehicleRepository::class);
    }
}

