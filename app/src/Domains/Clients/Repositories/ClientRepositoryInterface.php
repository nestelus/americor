<?php

declare(strict_types=1);

namespace App\Domains\Clients\Repositories;

use App\Domains\Clients\Entities\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;

    public function getBySsn(string $ssn): ?Client;

    public function update(string $ssn, array $data): void;
}
