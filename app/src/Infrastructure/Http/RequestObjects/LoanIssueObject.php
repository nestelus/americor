<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\RequestObjects;

class LoanIssueObject
{
    public const RULES = [
        [['title', 'term', 'rate', 'amount',], 'required'],
        [['term', 'rate', 'amount',], 'number'],
        [['title',], 'string'],
    ];
}
