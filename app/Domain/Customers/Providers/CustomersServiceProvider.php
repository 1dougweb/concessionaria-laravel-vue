<?php

namespace App\Domain\Customers\Providers;

use App\Domain\Customers\Repositories\CustomerRepositoryContract;
use App\Infrastructure\Persistence\Eloquent\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class CustomersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryContract::class, CustomerRepository::class);
    }
}

