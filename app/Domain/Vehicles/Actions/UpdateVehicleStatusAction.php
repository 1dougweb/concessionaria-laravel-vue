<?php

namespace App\Domain\Vehicles\Actions;

use App\Application\Events\VehicleStatusUpdated;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Services\VehicleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class UpdateVehicleStatusAction
{
    public function __construct(private readonly VehicleService $service)
    {
    }

    public function __invoke(Vehicle $vehicle, string $status, ?string $notes = null): Vehicle
    {
        $updated = $this->service->changeStatus($vehicle, $status, Auth::id(), $notes);

        Event::dispatch(new VehicleStatusUpdated($updated, $status));

        return $updated;
    }
}

