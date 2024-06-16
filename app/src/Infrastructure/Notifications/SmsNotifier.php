<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications;

use App\Domains\Clients\Entities\Client;
use App\Domains\Loans\Entities\Loan;
use App\Infrastructure\Notifications\Interfaces\SmsSenderInterface;

class SmsNotifier extends AbstractNotifier
{
    private SmsSenderInterface $sender;

    /**
     * @param  SmsSenderInterface  $sender
     */
    public function __construct(SmsSenderInterface $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param  Client  $client
     * @param  Loan  $loan
     * @return void
     */
    public function sendLoanApproval(Client $client, Loan $loan)
    {
        $this->sender->send($client->getPhone(), $this->subject($loan), $this->notifierText($client, $loan));
    }
}
