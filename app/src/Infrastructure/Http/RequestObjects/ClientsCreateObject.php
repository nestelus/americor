<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\RequestObjects;

class ClientsCreateObject
{
    public const RULES = [
        [
            [
                'first_name',
                'last_name',
                'age',
                'city',
                'state',
                'zip',
                'ssn',
                'fico',
                'income',
                'email',
                'phone',
            ], 'required',
        ],
        ['email', 'email'],
        [['age', 'income', 'fico'], 'number'],
        ['ssn', 'match', 'pattern' => '/^(?!666|000|9\\d{2})\\d{3}-(?!00)\\d{2}-(?!0{4})\\d{4}$/']
    ];
}
