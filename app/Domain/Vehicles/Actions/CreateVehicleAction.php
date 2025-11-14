<?php

namespace App\Domain\Vehicles\Actions;

use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Services\VehicleService;
use Illuminate\Support\Facades\Auth;

class CreateVehicleAction
{
    public function __construct(private readonly VehicleService $service)
    {
    }

    public function __invoke(VehicleData $data): Vehicle
    {
        return $this->service->create($data, Auth::id());
    }
}

