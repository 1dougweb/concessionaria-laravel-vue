<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Models\VehicleStatusHistory;
use App\Domain\Vehicles\Repositories\VehicleRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class VehicleRepository implements VehicleRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Vehicle::query()
            ->when($filters['search'] ?? null, fn (Builder $query, string $term) => $query->where(fn (Builder $nested) => $nested
                ->where('title', 'like', "%{$term}%")
                ->orWhere('brand', 'like', "%{$term}%")
                ->orWhere('model', 'like', "%{$term}%")))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['type'] ?? null, fn (Builder $query, string $type) => $query->where('type', $type))
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Vehicle
    {
        return Vehicle::query()->where('id', $uuid)->first();
    }

    public function create(VehicleData $data, ?int $userId = null): Vehicle
    {
        $payload = $this->mapToArray($data);
        $payload['created_by'] = $userId;
        $payload['slug'] = $payload['slug'] ?: Str::slug($payload['title'] . '-' . now()->timestamp);

        return Vehicle::query()->create($payload);
    }

    public function update(Vehicle $vehicle, VehicleData $data, ?int $userId = null): Vehicle
    {
        $payload = $this->mapToArray($data);
        $payload['updated_by'] = $userId;
        $vehicle->update($payload);

        return $vehicle->refresh();
    }

    public function updateStatus(Vehicle $vehicle, string $status, ?int $userId = null, ?string $notes = null): Vehicle
    {
        $previousStatus = $vehicle->status;
        $vehicle->update([
            'status' => $status,
            'updated_by' => $userId,
        ]);

        VehicleStatusHistory::query()->create([
            'vehicle_id' => $vehicle->id,
            'from_status' => $previousStatus,
            'to_status' => $status,
            'notes' => $notes,
            'changed_by' => $userId,
        ]);

        return $vehicle->refresh();
    }

    private function mapToArray(VehicleData $data): array
    {
        return [
            'customer_id' => $data->customerId,
            'title' => $data->title,
            'slug' => $data->slug,
            'type' => $data->type,
            'brand' => $data->brand,
            'model' => $data->model,
            'year' => $data->year,
            'mileage' => $data->mileage,
            'price' => $data->price,
            'currency' => $data->currency,
            'fuel_type' => $data->fuelType,
            'transmission' => $data->transmission,
            'status' => $data->status,
            'stock_count' => $data->stockCount,
            'description' => $data->description,
            'specifications' => $data->specifications,
            'metadata' => $data->metadata,
        ];
    }
}

