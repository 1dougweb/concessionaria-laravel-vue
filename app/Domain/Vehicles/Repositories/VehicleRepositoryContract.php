<?php

namespace App\Domain\Vehicles\Repositories;

use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VehicleRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByUuid(string $uuid): ?Vehicle;

    public function create(VehicleData $data, ?int $userId = null): Vehicle;

    public function update(Vehicle $vehicle, VehicleData $data, ?int $userId = null): Vehicle;

    public function updateStatus(Vehicle $vehicle, string $status, ?int $userId = null, ?string $notes = null): Vehicle;
}

