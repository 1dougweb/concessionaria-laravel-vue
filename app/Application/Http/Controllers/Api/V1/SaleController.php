<?php

namespace App\Application\Http\Controllers\Api\V1;

use App\Domain\Sales\Actions\FinalizeSaleAction;
use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Repositories\SaleRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(private readonly SaleRepositoryContract $sales)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $collection = $this->sales->paginate(
            filters: $request->only(['status', 'seller_id']),
            perPage: (int) $request->get('per_page', 15)
        );

        return response()->json($collection);
    }

    public function show(Sale $sale): JsonResponse
    {
        return response()->json($sale->load(['vehicle', 'customer', 'payments']));
    }

    public function finalize(Request $request, Sale $sale, FinalizeSaleAction $finalizeSaleAction): JsonResponse
    {
        $payload = $request->validate([
            'status' => ['nullable', 'string'],
            'metadata' => ['nullable', 'array'],
        ]);

        $updated = $finalizeSaleAction($sale, $payload);

        return response()->json($updated);
    }
}

