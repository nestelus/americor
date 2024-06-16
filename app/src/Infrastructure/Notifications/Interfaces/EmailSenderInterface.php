<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications\Interfaces;

interface EmailSenderInterface
{
    public function send($email, $subject, $message): void;
}
