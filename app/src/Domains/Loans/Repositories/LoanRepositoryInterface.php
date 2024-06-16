<?php

declare(strict_types=1);

namespace App\Domains\Loans\Repositories;

use App\Domains\Clients\Entities\Client;
use App\Domains\Loans\Entities\Loan;

interface LoanRepositoryInterface
{
    public function save(Loan $loan ): void;
}
