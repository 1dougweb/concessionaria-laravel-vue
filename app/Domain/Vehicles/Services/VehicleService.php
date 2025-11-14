<?php

namespace App\Domain\Vehicles\Services;

use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Repositories\VehicleRepositoryContract;

class VehicleService
{
    public function __construct(private readonly VehicleRepositoryContract $repository)
    {
    }

    public function create(VehicleData $data, ?int $userId = null): Vehicle
    {
        return $this->repository->create($data, $userId);
    }

    public function update(Vehicle $vehicle, VehicleData $data, ?int $userId = null): Vehicle
    {
        return $this->repository->update($vehicle, $data, $userId);
    }

    public function changeStatus(Vehicle $vehicle, string $status, ?int $userId = null, ?string $notes = null): Vehicle
    {
        return $this->repository->updateStatus($vehicle, $status, $userId, $notes);
    }
}

