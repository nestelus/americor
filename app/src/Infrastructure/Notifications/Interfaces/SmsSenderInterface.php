<?php

declare(strict_types=1);

namespace App\Infrastructure\Notifications\Interfaces;

interface SmsSenderInterface
{
    public function send($number, $subject, $message): void;
}
