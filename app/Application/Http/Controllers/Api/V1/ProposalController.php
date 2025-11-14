<?php

namespace App\Application\Http\Controllers\Api\V1;

use App\Application\Http\Requests\Api\V1\Proposals\CheckoutProposalRequest;
use App\Application\Http\Requests\Api\V1\Proposals\StoreProposalRequest;
use App\Application\Http\Requests\Api\V1\Proposals\UpdateProposalRequest;
use App\Domain\Proposals\Actions\CheckoutProposalAction;
use App\Domain\Proposals\Actions\CreateProposalAction;
use App\Domain\Proposals\Actions\SubmitProposalAction;
use App\Domain\Proposals\DTOs\ProposalData;
use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Repositories\ProposalRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProposalController extends Controller
{
    public function __construct(private readonly ProposalRepositoryContract $proposals)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $collection = $this->proposals->paginate(
            filters: $request->only(['status', 'vehicle_id', 'customer_id']),
            perPage: (int) $request->get('per_page', 15)
        );

        return response()->json($collection);
    }

    public function store(
        StoreProposalRequest $request,
        CreateProposalAction $createProposalAction
    ): JsonResponse {
        $proposal = $createProposalAction(ProposalData::fromArray($request->validated()));

        return response()->json($proposal, Response::HTTP_CREATED);
    }

    public function show(Proposal $proposal): JsonResponse
    {
        return response()->json($proposal);
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal): JsonResponse
    {
        $updated = $this->proposals->update($proposal, $request->validated());

        return response()->json($updated);
    }

    public function submit(Proposal $proposal, SubmitProposalAction $submitProposalAction): JsonResponse
    {
        $updated = $submitProposalAction($proposal);

        return response()->json($updated);
    }

    public function checkout(
        CheckoutProposalRequest $request,
        Proposal $proposal,
        CheckoutProposalAction $checkoutProposalAction
    ): JsonResponse {
        $updated = $checkoutProposalAction($proposal, $request->validated());

        return response()->json($updated);
    }
}

