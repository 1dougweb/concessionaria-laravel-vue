<?php

namespace App\Application\Http\Controllers\Api\V1;

use App\Application\Http\Requests\Api\V1\Customers\StoreCustomerRequest;
use App\Application\Http\Requests\Api\V1\Customers\UpdateCustomerRequest;
use App\Domain\Customers\DTOs\CustomerData;
use App\Domain\Customers\Models\Customer;
use App\Domain\Customers\Repositories\CustomerRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerRepositoryContract $customers)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = min(max($perPage, 1), 100);

        $collection = $this->customers->paginate(
            filters: $request->only(['status', 'search']),
            perPage: $perPage
        );

        return response()->json($collection);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customers->create(CustomerData::fromArray($request->validated()));

        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function show(Customer $customer): JsonResponse
    {
        return response()->json($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $payload = array_merge(
            $customer->only($customer->getFillable()),
            $request->validated()
        );

        $updated = $this->customers->update(
            $customer,
            CustomerData::fromArray($payload),
        );

        return response()->json($updated);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->noContent();
    }
}

