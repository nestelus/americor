<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications;

use App\Domains\Clients\Entities\Client;
use App\Domains\Loans\Entities\Loan;
use App\Infrastructure\Notifications\Interfaces\EmailSenderInterface;

class EmailNotifier extends AbstractNotifier
{
    private EmailSenderInterface $sender;

    /**
     * @param  EmailSenderInterface  $sender
     */
    public function __construct(EmailSenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function sendLoanApproval(Client $client, Loan $loan)
    {
        $this->sender->send($client->getEmail(), $this->subject($loan), $this->notifierText($client, $loan));
    }
}
