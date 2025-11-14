<?php

namespace App\Domain\Vehicles\Actions;

use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Services\VehicleService;
use Illuminate\Support\Facades\Auth;

class UpdateVehicleAction
{
    public function __construct(private readonly VehicleService $service)
    {
    }

    public function __invoke(Vehicle $vehicle, VehicleData $data): Vehicle
    {
        return $this->service->update($vehicle, $data, Auth::id());
    }
}

