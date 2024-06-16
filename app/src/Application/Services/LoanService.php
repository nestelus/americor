<?php
// src/Application/Services/LoanService.php
namespace App\Application\Services;

use App\Domain\Entities\Client;
use App\Domain\Entities\Loan;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Domain\Repositories\LoanRepositoryInterface;
use App\Infrastructure\Notifications\EmailNotifier;
use App\Infrastructure\Notifications\SmsNotifier;

class LoanService {
    private LoanRepositoryInterface $loanRepository;
    private ClientRepositoryInterface $clientRepository;
    private EmailNotifier $emailNotifier;
    private SmsNotifier $smsNotifier;

    public function __construct(
        LoanRepositoryInterface $loanRepository,
        ClientRepositoryInterface $clientRepository,
        EmailNotifier $emailNotifier,
        SmsNotifier $smsNotifier
    ) {
        $this->loanRepository = $loanRepository;
        $this->clientRepository = $clientRepository;
        $this->emailNotifier = $emailNotifier;
        $this->smsNotifier = $smsNotifier;
    }

    public function checkEligibility(Client $client): bool {
        if ($client->getFico()->getScore() <= 500) {
            return false;
        }
        if ($client->getIncome() < 1000) {
            return false;
        }
        if ($client->getAge() < 18 || $client->getAge() > 60) {
            return false;
        }
        $state = $client->getAddress()->getState();
        if (!in_array($state, ['CA', 'NY', 'NV'])) {
            return false;
        }
        if ($state === 'NY' && rand(0, 1) === 0) {
            return false;
        }
        return true;
    }

    public function issueLoan(Client $client, array $loanData): Loan {
        if (!$this->checkEligibility($client)) {
            throw new \Exception("Client is not eligible for a loan");
        }
        $interestRate = $loanData['interestRate'];
        if ($client->getAddress()->getState() === 'CA') {
            $interestRate += 11.49;
        }
        $loan = new Loan(
            $loanData['productName'],
            $loanData['term'],
            $interestRate,
            $loanData['amount']
        );
        $this->loanRepository.save($loan);
        $this->notifyClient($client, $loan);
        return $loan;
    }

    private function notifyClient(Client $client, Loan $loan): void {
        $this->emailNotifier->sendLoanApproval($client, $loan);
        $this->smsNotifier->sendLoanApproval($client, $loan);
    }
}
