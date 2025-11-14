<?php

namespace App\Domain\Customers\DTOs;

class CustomerData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $documentNumber,
        public readonly array $address,
        public readonly array $preferences,
        public readonly string $status,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            name: $payload['name'],
            email: $payload['email'],
            phone: $payload['phone'] ?? null,
            documentNumber: $payload['document_number'] ?? null,
            address: $payload['address'] ?? [],
            preferences: $payload['preferences'] ?? [],
            status: $payload['status'] ?? 'active',
        );
    }
}

