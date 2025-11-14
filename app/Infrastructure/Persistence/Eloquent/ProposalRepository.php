<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Proposals\DTOs\ProposalData;
use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Repositories\ProposalRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProposalRepository implements ProposalRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Proposal::query()
            ->with(['vehicle', 'customer'])
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['vehicle_id'] ?? null, fn (Builder $query, string $vehicleId) => $query->where('vehicle_id', $vehicleId))
            ->when($filters['customer_id'] ?? null, fn (Builder $query, string $customerId) => $query->where('customer_id', $customerId))
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Proposal
    {
        return Proposal::query()->where('id', $uuid)->first();
    }

    public function create(ProposalData $data): Proposal
    {
        return Proposal::query()->create($this->mapToArray($data));
    }

    public function update(Proposal $proposal, array $payload): Proposal
    {
        $proposal->update($payload);

        return $proposal->refresh();
    }

    private function mapToArray(ProposalData $data): array
    {
        return [
            'vehicle_id' => $data->vehicleId,
            'customer_id' => $data->customerId,
            'seller_id' => $data->sellerId,
            'amount' => $data->amount,
            'status' => $data->status,
            'financing' => $data->financing,
            'metadata' => $data->metadata,
            'expires_at' => $data->expiresAt,
        ];
    }
}

