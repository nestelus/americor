<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications\Senders;

use App\Infrastructure\Notifications\Interfaces\SmsSenderInterface;

class SmsSender implements SmsSenderInterface
{

    public function send($number, $subject, $message): void
    {
        // TODO: Implement send() method.
    }
}
