<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\ClientService;
use App\Infrastructure\Http\RequestObjects\ClientsCreateObject;
use App\Infrastructure\Http\RequestObjects\ClientUpdateObject;
use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;

class ClientController extends Controller
{
    private ClientService $clientService;

    /**
     * @param $id
     * @param $module
     * @param ClientService  $clientService
     * @param  array  $config
     */
    public function __construct($id, $module, ClientService $clientService, array $config = [])
    {
        $this->clientService = $clientService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public function actionCreate(): array
    {
        $request = DynamicModel::validateData(Yii::$app->request->post(), ClientsCreateObject::RULES);

        if ($request->hasErrors()) {
            return $request->errors;
        }
        $client = $this->clientService->createClient($request->getAttributes());
        return $client->toArray();
    }

    /**
     * @param  string  $ssn
     * @return string[]
     * @throws InvalidConfigException
     */
    public function actionUpdate(string $ssn): array
    {
        $data = Yii::$app->request->post();
        $request = DynamicModel::validateData($data, ClientUpdateObject::RULES);

        if ($request->hasErrors()) {
            return $request->errors;
        }
        try {
            $this->clientService->updateClient($ssn, $request->getAttributes(array_keys($data)));
            return ['status' => 'success'];
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @param  string  $ssn
     * @return array
     */
    public function actionView(string $ssn): array
    {
        try {
            $client = $this->clientService->getClientById($ssn);
            return $client->toArray();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
