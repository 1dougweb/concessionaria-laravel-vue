<?php

namespace App\Domain\Vehicles\DTOs;

class VehicleData
{
    public function __construct(
        public readonly ?string $customerId,
        public readonly string $title,
        public readonly ?string $slug,
        public readonly string $type,
        public readonly string $brand,
        public readonly string $model,
        public readonly int $year,
        public readonly int $mileage,
        public readonly float $price,
        public readonly string $currency,
        public readonly ?string $fuelType,
        public readonly ?string $transmission,
        public readonly string $status,
        public readonly int $stockCount,
        public readonly ?string $description,
        public readonly array $specifications,
        public readonly array $metadata,
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            customerId: $payload['customer_id'] ?? null,
            title: $payload['title'],
            slug: $payload['slug'] ?? null,
            type: $payload['type'],
            brand: $payload['brand'],
            model: $payload['model'],
            year: (int) $payload['year'],
            mileage: (int) ($payload['mileage'] ?? 0),
            price: (float) $payload['price'],
            currency: $payload['currency'] ?? 'BRL',
            fuelType: $payload['fuel_type'] ?? null,
            transmission: $payload['transmission'] ?? null,
            status: $payload['status'] ?? 'draft',
            stockCount: (int) ($payload['stock_count'] ?? 1),
            description: $payload['description'] ?? null,
            specifications: $payload['specifications'] ?? [],
            metadata: $payload['metadata'] ?? [],
        );
    }
}

