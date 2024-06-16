<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domains\Loans\Entities\Loan;
use App\Domains\Loans\Repositories\LoanRepositoryInterface;
use App\Infrastructure\Persistence\Models\Client as ClientPersistence;
use App\Infrastructure\Persistence\Models\Loan as LoanPersistence;
use yii\db\Exception;

class LoanRepository implements LoanRepositoryInterface
{

    /**
     * @throws Exception
     */
    public function save(Loan $loan): void
    {
        $loanPersistence = LoanPersistence::findOne(['number' => $loan->getNumber()]);
        if (! $loanPersistence) {
            $loanPersistence = new LoanPersistence();
        }

        $loanPersistence->title = $loan->getTitle();
        $loanPersistence->term = $loan->getTerm();
        $loanPersistence->rate = $loan->getRate();
        $loanPersistence->number = $loan->getNumber();
        $loanPersistence->amount = $loan->getAmount();
        $loanPersistence->status = $loan->isStatus();
        $owner = ClientPersistence::findOne(['ssn' => $loan->getOwner()->getSsn()]);
        $loanPersistence->client_id = $owner->id;

        $loanPersistence->save();
    }
}
