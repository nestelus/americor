<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domains\Clients\Entities\Client;
use App\Domains\Clients\Repositories\ClientRepositoryInterface;

class ClientService
{
    private ClientRepositoryInterface $clientRepository;

    /**
     * @param  ClientRepositoryInterface  $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param  array  $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $client = Client::create($data);
        $this->clientRepository->save($client);
        return $client;
    }

    /**
     * @param  string  $ssn
     * @param  array  $data
     * @return void
     */
    public function updateClient(string $ssn, array $data): void
    {
        $this->clientRepository->update($ssn, $data);
    }

    /**
     * @param  string  $ssn
     * @return Client
     */
    public function getClientById(string $ssn): Client
    {
        return $this->clientRepository->getBySsn($ssn);
    }
}
