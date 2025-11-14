<?php

namespace App\Domain\Proposals\Providers;

use App\Domain\Proposals\Repositories\ProposalRepositoryContract;
use App\Infrastructure\Persistence\Eloquent\ProposalRepository;
use Illuminate\Support\ServiceProvider;

class ProposalsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProposalRepositoryContract::class, ProposalRepository::class);
    }
}

