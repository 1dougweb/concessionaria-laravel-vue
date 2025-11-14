<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Sales\DTOs\SaleData;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Repositories\SaleRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SaleRepository implements SaleRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Sale::query()
            ->with(['vehicle', 'customer', 'proposal'])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['seller_id'] ?? null, fn (Builder $query, int $sellerId) => $query->where('seller_id', $sellerId))
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Sale
    {
        return Sale::query()->where('id', $uuid)->first();
    }

    public function create(SaleData $data): Sale
    {
        return Sale::query()->create($this->mapToArray($data));
    }

    public function update(Sale $sale, array $payload): Sale
    {
        $sale->update($payload);

        return $sale->refresh();
    }

    private function mapToArray(SaleData $data): array
    {
        return [
            'proposal_id' => $data->proposalId,
            'vehicle_id' => $data->vehicleId,
            'customer_id' => $data->customerId,
            'seller_id' => $data->sellerId,
            'total_amount' => $data->totalAmount,
            'status' => $data->status,
            'metadata' => $data->metadata,
        ];
    }
}

