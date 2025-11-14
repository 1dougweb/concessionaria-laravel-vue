<?php

namespace App\Domain\Sales\DTOs;

class SaleData
{
    public function __construct(
        public readonly string $proposalId,
        public readonly string $vehicleId,
        public readonly string $customerId,
        public readonly ?int $sellerId,
        public readonly float $totalAmount,
        public readonly string $status,
        public readonly array $metadata,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            proposalId: $payload['proposal_id'],
            vehicleId: $payload['vehicle_id'],
            customerId: $payload['customer_id'],
            sellerId: $payload['seller_id'] ?? null,
            totalAmount: (float) $payload['total_amount'],
            status: $payload['status'] ?? 'pending',
            metadata: $payload['metadata'] ?? [],
        );
    }
}

