<?php

namespace App\Domain\Proposals\DTOs;

class ProposalData
{
    public function __construct(
        public readonly string $vehicleId,
        public readonly string $customerId,
        public readonly ?int $sellerId,
        public readonly float $amount,
        public readonly string $status,
        public readonly array $financing,
        public readonly array $metadata,
        public readonly ?string $expiresAt,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            vehicleId: $payload['vehicle_id'],
            customerId: $payload['customer_id'],
            sellerId: $payload['seller_id'] ?? null,
            amount: (float) $payload['amount'],
            status: $payload['status'] ?? 'draft',
            financing: $payload['financing'] ?? [],
            metadata: $payload['metadata'] ?? [],
            expiresAt: $payload['expires_at'] ?? null,
        );
    }
}

