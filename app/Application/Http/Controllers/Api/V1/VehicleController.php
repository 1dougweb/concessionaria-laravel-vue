<?php

namespace App\Application\Http\Controllers\Api\V1;

use App\Application\Http\Requests\Api\V1\Vehicles\StoreVehicleRequest;
use App\Application\Http\Requests\Api\V1\Vehicles\UpdateVehicleRequest;
use App\Application\Http\Requests\Api\V1\Vehicles\UpdateVehicleStatusRequest;
use App\Domain\Vehicles\Actions\CreateVehicleAction;
use App\Domain\Vehicles\Actions\UpdateVehicleAction;
use App\Domain\Vehicles\Actions\UpdateVehicleStatusAction;
use App\Domain\Vehicles\DTOs\VehicleData;
use App\Domain\Vehicles\Models\Vehicle;
use App\Domain\Vehicles\Repositories\VehicleRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends Controller
{
    public function __construct(private readonly VehicleRepositoryContract $vehicles)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 15);
        $perPage = min(max($perPage, 1), 100);

        $collection = $this->vehicles->paginate(
            filters: $request->only(['search', 'status', 'type']),
            perPage: $perPage
        );

        return response()->json($collection);
    }

    public function store(
        StoreVehicleRequest $request,
        CreateVehicleAction $createVehicleAction
    ): JsonResponse {
        $vehicle = $createVehicleAction(VehicleData::fromArray($request->validated()));

        return response()->json($vehicle, Response::HTTP_CREATED);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json($vehicle);
    }

    public function update(
        UpdateVehicleRequest $request,
        Vehicle $vehicle,
        UpdateVehicleAction $updateVehicleAction
    ): JsonResponse {
        $payload = array_merge(
            $vehicle->only($vehicle->getFillable()),
            $request->validated()
        );

        $updated = $updateVehicleAction($vehicle, VehicleData::fromArray($payload));

        return response()->json($updated);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return response()->noContent();
    }

    public function updateStatus(
        UpdateVehicleStatusRequest $request,
        Vehicle $vehicle,
        UpdateVehicleStatusAction $updateVehicleStatusAction
    ): JsonResponse {
        $updated = $updateVehicleStatusAction(
            $vehicle,
            $request->string('status')->toString(),
            $request->input('notes')
        );

        return response()->json($updated);
    }
}

