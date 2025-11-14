<?php

namespace App\Domain\Proposals\Actions;

use App\Domain\Proposals\DTOs\ProposalData;
use App\Domain\Proposals\Models\Proposal;
use App\Domain\Proposals\Repositories\ProposalRepositoryContract;

class CreateProposalAction
{
    public function __construct(private readonly ProposalRepositoryContract $repository)
    {
    }

    public function __invoke(ProposalData $data): Proposal
    {
        return $this->repository->create($data);
    }
}

