<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domains\Clients\Entities\Client;
use App\Domains\Loans\Entities\Loan;
use App\Domains\Loans\Repositories\LoanRepositoryInterface;
use App\Infrastructure\Notifications\EmailNotifier;
use App\Infrastructure\Notifications\SmsNotifier;

class LoanService
{
    private LoanRepositoryInterface $loanRepository;
    private EmailNotifier $emailNotifier;
    private SmsNotifier $smsNotifier;

    public function __construct(
        LoanRepositoryInterface $loanRepository,
        EmailNotifier $emailNotifier,
        SmsNotifier $smsNotifier
    ) {
        $this->loanRepository = $loanRepository;
        $this->emailNotifier = $emailNotifier;
        $this->smsNotifier = $smsNotifier;
    }

    /**
     * @param  Client  $client
     * @return bool
     */
    public function checkEligibility(Client $client): bool
    {
        if ($client->getFico() <= 500) {
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

    /**
     * @param  Client  $client
     * @param  array  $loanData
     * @return Loan
     * @throws \Exception
     */
    public function issueLoan(Client $client, array $loanData): Loan
    {
        $status = $this->checkEligibility($client);

        $interestRate = $loanData['rate'];
        if ($client->getAddress()->getState() === 'CA') {
            $interestRate += 11.49;
        }
        $loan = new Loan(
            title: $loanData['title'],
            term: (string)$loanData['term'],
            rate: (string)$interestRate,
            amount: (string)$loanData['amount'],
            owner: $client,
            status: $status
        );
        $this->loanRepository->save($loan);
        $this->notifyClient($client, $loan);
        return $loan;
    }

    /**
     * @param  Client  $client
     * @param  Loan  $loan
     * @return void
     */
    private function notifyClient(Client $client, Loan $loan): void
    {
        $this->emailNotifier->sendLoanApproval($client, $loan);
        $this->smsNotifier->sendLoanApproval($client, $loan);
    }
}
