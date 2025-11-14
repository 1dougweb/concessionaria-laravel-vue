<?php

namespace App\Domain\Sales\Actions;

use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Services\SaleService;

class FinalizeSaleAction
{
    public function __construct(private readonly SaleService $service)
    {
    }

    public function __invoke(Sale $sale, array $payload = []): Sale
    {
        return $this->service->finalize($sale, $payload);
    }
}

