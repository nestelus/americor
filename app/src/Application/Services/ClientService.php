<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domains\Clients\Entities\Client;
use App\Domains\Clients\Repositories\ClientRepositoryInterface;

class ClientService
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function createClient(array $data): Client
    {
        $client = Client::create($data);
        $this->clientRepository->save($client);
        return $client;
    }

    public function updateClient(string $ssn, array $data): void
    {
        $this->clientRepository->update($ssn, $data);
    }

    public function getClientById(string $ssn): Client
    {
        return $this->clientRepository->getBySsn($ssn);
    }
}
