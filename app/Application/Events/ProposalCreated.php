<?php

namespace App\Application\Events;

use App\Domain\Proposals\Models\Proposal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalCreated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public readonly Proposal $proposal)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("proposals.user.{$this->proposal->seller_id}"),
            new Channel('proposals.feed'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'status' => $this->proposal->status,
            'vehicle_id' => $this->proposal->vehicle_id,
            'customer_id' => $this->proposal->customer_id,
            'amount' => $this->proposal->amount,
        ];
    }

    public function broadcastAs(): string
    {
        return 'ProposalCreated';
    }
}

