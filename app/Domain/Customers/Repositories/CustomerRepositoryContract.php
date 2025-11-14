<?php

namespace App\Domain\Customers\Repositories;

use App\Domain\Customers\DTOs\CustomerData;
use App\Domain\Customers\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByUuid(string $uuid): ?Customer;

    public function create(CustomerData $data): Customer;

    public function update(Customer $customer, CustomerData $data): Customer;
}

