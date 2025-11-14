<?php

use App\Domain\Vehicles\Models\Vehicle;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('vehicles.status.{vehicleId}', function ($user, string $vehicleId) {
    return $user !== null && Vehicle::query()->whereKey($vehicleId)->exists();
});

Broadcast::channel('proposals.user.{userId}', function ($user, int $userId) {
    return $user !== null && $user->id === $userId;
});

Broadcast::channel('proposals.feed', fn () => true);
Broadcast::channel('vehicles.feed', fn () => true);

