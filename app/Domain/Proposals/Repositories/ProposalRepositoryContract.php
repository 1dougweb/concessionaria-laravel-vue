<?php

namespace App\Domain\Proposals\Repositories;

use App\Domain\Proposals\DTOs\ProposalData;
use App\Domain\Proposals\Models\Proposal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProposalRepositoryContract
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByUuid(string $uuid): ?Proposal;

    public function create(ProposalData $data): Proposal;

    public function update(Proposal $proposal, array $payload): Proposal;
}

