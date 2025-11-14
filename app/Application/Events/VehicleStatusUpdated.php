<?php

namespace App\Application\Events;

use App\Domain\Vehicles\Models\Vehicle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleStatusUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly Vehicle $vehicle,
        public readonly string $status
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('vehicles.feed'),
            new PrivateChannel("vehicles.status.{$this->vehicle->id}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'vehicle_id' => $this->vehicle->id,
            'status' => $this->status,
        ];
    }

    public function broadcastAs(): string
    {
        return 'VehicleStatusUpdated';
    }
}

