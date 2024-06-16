<?php

declare(strict_types=1);


namespace App\Infrastructure\Http\RequestObjects;

class ClientUpdateObject
{
    public const RULES = [
        ['email', 'email', 'skipOnEmpty' => true],
        [['age', 'income', 'fico'], 'number', 'skipOnEmpty' => true],
    ];
}
