<?php

namespace App\Domain\Proposals\Actions;

use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Services\ProposalWorkflowService;

class CheckoutProposalAction
{
    public function __construct(private readonly ProposalWorkflowService $service)
    {
    }

    public function __invoke(Proposal $proposal, array $payload): Proposal
    {
        return $this->service->checkout($proposal, $payload);
    }
}

