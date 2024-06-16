<?php
// src/Infrastructure/Http/Controllers/LoanController.php
namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\LoanService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class LoanController extends Controller {
    private LoanService $loanService;

    public function __construct($id, $module, LoanService $loanService, $config = []) {
        $this->loanService = $loanService;
        parent::__construct($id, $module, $config);
    }

    public function actionIssue() {
        $data = Yii::$app->request->post();
        $clientId = $data['clientId'];
        $client = $this->clientService->findById($clientId);
        $loan = $this->loanService->issueLoan($client, $data);
        return $this->asJson($loan);
    }
}
