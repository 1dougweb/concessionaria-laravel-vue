<?php

namespace App\Domain\Sales\Services;

use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Repositories\SaleRepositoryContract;

class SaleService
{
    public function __construct(private readonly SaleRepositoryContract $repository)
    {
    }

    public function finalize(Sale $sale, array $payload = []): Sale
    {
        return $this->repository->update($sale, [
            'status' => $payload['status'] ?? 'completed',
            'metadata' => array_merge($sale->metadata ?? [], $payload['metadata'] ?? []),
            'closed_at' => now(),
        ]);
    }
}

