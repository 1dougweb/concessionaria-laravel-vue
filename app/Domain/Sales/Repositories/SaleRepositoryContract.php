<?php

namespace App\Domain\Sales\Repositories;

use App\Domain\Sales\DTOs\SaleData;
use App\Domain\Sales\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SaleRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByUuid(string $uuid): ?Sale;

    public function create(SaleData $data): Sale;

    public function update(Sale $sale, array $payload): Sale;
}

