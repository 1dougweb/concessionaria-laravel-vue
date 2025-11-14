<?php

namespace App\Domain\Proposals\Services;

use App\Application\Events\ProposalCreated;
use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Repositories\ProposalRepositoryContract;
use App\Domain\Sales\DTOs\SaleData;
use App\Domain\Sales\Repositories\SaleRepositoryContract;
use Illuminate\Support\Facades\Event;

class ProposalWorkflowService
{
    public function __construct(
        private readonly ProposalRepositoryContract $proposalRepository,
        private readonly SaleRepositoryContract $saleRepository,
    ) {
    }

    public function submit(Proposal $proposal): Proposal
    {
        if ($proposal->status !== 'draft') {
            return $proposal;
        }

        $updated = $this->proposalRepository->update($proposal, [
            'status' => 'submitted',
        ]);

        Event::dispatch(new ProposalCreated($updated));

        return $updated;
    }

    public function updateStatus(Proposal $proposal, string $status, array $metadata = []): Proposal
    {
        return $this->proposalRepository->update($proposal, [
            'status' => $status,
            'metadata' => array_merge($proposal->metadata ?? [], $metadata),
        ]);
    }

    public function checkout(Proposal $proposal, array $payload): Proposal
    {
        $saleData = SaleData::fromArray([
            'proposal_id' => $proposal->id,
            'vehicle_id' => $proposal->vehicle_id,
            'customer_id' => $proposal->customer_id,
            'seller_id' => $proposal->seller_id,
            'total_amount' => $payload['total_amount'],
            'status' => 'pending',
            'metadata' => $payload['metadata'] ?? [],
        ]);

        $this->saleRepository->create($saleData);

        return $this->updateStatus($proposal, 'under_review', [
            'checkout' => $payload,
        ]);
    }
}

