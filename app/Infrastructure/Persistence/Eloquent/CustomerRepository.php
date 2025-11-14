<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Customers\DTOs\CustomerData;
use App\Domain\Customers\Models\Customer;
use App\Domain\Customers\Repositories\CustomerRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CustomerRepository implements CustomerRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Customer::query()
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, fn (Builder $query, string $search) => $query->where(fn (Builder $nested) => $nested
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Customer
    {
        return Customer::query()->where('id', $uuid)->first();
    }

    public function create(CustomerData $data): Customer
    {
        return Customer::query()->create($this->mapToArray($data));
    }

    public function update(Customer $customer, CustomerData $data): Customer
    {
        $customer->update($this->mapToArray($data));

        return $customer->refresh();
    }

    private function mapToArray(CustomerData $data): array
    {
        return [
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'document_number' => $data->documentNumber,
            'address' => $data->address,
            'preferences' => $data->preferences,
            'status' => $data->status,
        ];
    }
}

