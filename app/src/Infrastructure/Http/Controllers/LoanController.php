<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\ClientService;
use App\Application\Services\LoanService;
use App\Infrastructure\Http\RequestObjects\LoanIssueObject;
use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LoanController extends Controller
{
    private LoanService $loanService;
    private ClientService $clientService;

    public function __construct(
        $id,
        $module,
        LoanService $loanService,
        ClientService $clientService,
        array $config = []
    ) {
        $this->loanService = $loanService;
        $this->clientService = $clientService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws InvalidConfigException
     * @throws \Exception
     */
    public function actionIssue(string $ssn): array
    {
        $request = DynamicModel::validateData(Yii::$app->request->post(), LoanIssueObject::RULES);

        if ($request->hasErrors()) {
            return $request->errors;
        }

        $data = $request->getAttributes();
        try {
            $client = $this->clientService->getClientById($ssn);
            $loan = $this->loanService->issueLoan($client, $data);
            return $loan->toArray();
        } catch (NotFoundHttpException $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}
