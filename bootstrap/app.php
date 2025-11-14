<?php

use App\Domain\Customers\Providers\CustomersServiceProvider;
use App\Domain\Proposals\Providers\ProposalsServiceProvider;
use App\Domain\Sales\Providers\SalesServiceProvider;
use App\Domain\Vehicles\Providers\VehiclesServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withProviders([
        VehiclesServiceProvider::class,
        CustomersServiceProvider::class,
        ProposalsServiceProvider::class,
        SalesServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
