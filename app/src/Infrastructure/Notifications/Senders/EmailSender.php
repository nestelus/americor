<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications\Senders;

use App\Infrastructure\Notifications\Interfaces\EmailSenderInterface;

class EmailSender implements EmailSenderInterface
{

    public function send($email, $subject, $message): void
    {
        // TODO: Implement send() method.
    }
}
