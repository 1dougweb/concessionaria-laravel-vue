<?php

namespace App\Domain\Proposals\Actions;

use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Services\ProposalWorkflowService;

class SubmitProposalAction
{
    public function __construct(private readonly ProposalWorkflowService $service)
    {
    }

    public function __invoke(Proposal $proposal): Proposal
    {
        return $this->service->submit($proposal);
    }
}

