<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications;

use App\Domains\Clients\Entities\Client;
use App\Domains\Loans\Entities\Loan;

abstract class AbstractNotifier
{
    /**
     * @param  Client  $client
     * @param  Loan  $loan
     * @return string
     */
    protected function notifierText(Client $client, Loan $loan): string
    {
        $txt = 'Уважаемый ' . $client->getName()->getFirstName() . '! ';
        $txt .= $loan->isStatus() ? $this->loanTextPositive($loan) : $this->loanTextNegative($loan);

        return $txt;
    }

    /**
     * @param  Loan  $loan
     * @return string
     */
    private function loanTextPositive(Loan $loan): string
    {
        return 'Вам одобрен кредит ' . $loan->getTitle() . ' сроком на ' . $loan->getTerm() . ' месяцев на сумму' . $loan->getAmount() . '.';
    }

    /**
     * @param  Loan  $loan
     * @return string
     */
    private function loanTextNegative(Loan $loan): string
    {
        return 'В выдаче кредита ' . $loan->getTitle() . 'на сумму' . $loan->getAmount() . ' сроком на ' . $loan->getTerm() . ' месяцев Вам отказано';
    }

    /**
     * @param  Loan  $loan
     * @return string
     */
    protected function subject(Loan $loan): string
    {
        return $loan->isStatus() ? 'Вам одобрен кредит!' : 'вам отказано в кредите';
    }


}
