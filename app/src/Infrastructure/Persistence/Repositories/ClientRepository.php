<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Clients\Entities\Client;
use App\Domains\Clients\Repositories\ClientRepositoryInterface;
use App\Infrastructure\Persistence\Models\Client as PersistenceClient;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function save(Client $client): void
    {
        $persistenceClient = PersistenceClient::findOne(['ssn' => $client->getSsn()]);
        if (!$persistenceClient) {
            $persistenceClient = new PersistenceClient();
        }
        $persistenceClient = $this->clientToModel($client, $persistenceClient);

        $persistenceClient->save();
    }

    /**
     * @param  string  $ssn
     * @return Client
     * @throws \Exception
     */
    public function getBySsn(string $ssn): Client
    {
        $persistenceClient = PersistenceClient::findOne(['ssn' => $ssn]);

        if (!$persistenceClient) {
            throw new NotFoundHttpException("Client not found");
        }

        return Client::create($persistenceClient->toArray());
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function update(string $ssn, array $data): void
    {
        $persistenceClient = PersistenceClient::findOne(['ssn' => $ssn]);
        if (!$persistenceClient) {
            throw new NotFoundHttpException("Client not found");
        }
        $persistenceClient->updateAttributes($data);
        $persistenceClient->save();
    }

    /**
     * @param  Client  $client
     * @param  PersistenceClient  $model
     * @return PersistenceClient
     */
    private function clientToModel(Client $client, PersistenceClient $model): PersistenceClient
    {
        $model->first_name = $client->getName()->getFirstName();
        $model->last_name = $client->getName()->getLastName();
        $model->age = $client->getAge();
        $model->city = $client->getAddress()->getCity();
        $model->state = $client->getAddress()->getState();
        $model->zip = $client->getAddress()->getZip();
        $model->ssn = $client->getSsn();
        $model->income = $client->getIncome();
        $model->fico = $client->getFico();
        $model->email = $client->getEmail();
        $model->phone = $client->getPhone();

        return $model;
    }
}
