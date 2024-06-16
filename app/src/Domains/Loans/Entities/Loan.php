<?php

declare(strict_types=1);

namespace App\Domains\Loans\Entities;

use App\Domains\Clients\Entities\Client;

class Loan
{
    private string $title;
    private int $term;
    private float $rate;
    private float $amount;
    private Client $owner;
    private bool $status;
    private ?string $number;

    /**
     * @param  string  $title
     * @param  string  $term
     * @param  string  $rate
     * @param  string  $amount
     */
    public function __construct(string $title, string $term, string $rate, string $amount, Client $owner, $status = false, ?string $number = null )
    {
        $this->setTitle($title);
        $this->setTerm($term);
        $this->setRate($rate);
        $this->setAmount($amount);
        $this->setOwner($owner);
        $this->setStatus($status);
        $this->setNumber($number);
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param  bool  $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getTerm(): int
    {
        return $this->term;
    }

    /**
     * @param  string  $term
     */
    public function setTerm(string $term): void
    {
        $this->term = (int) $term;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param  string  $rate
     */
    public function setRate(string $rate): void
    {
        $this->rate = (float) $rate;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param  string  $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = (float) $amount;
    }

    /**
     * @return Client
     */
    public function getOwner(): Client
    {
        return $this->owner;
    }

    /**
     * @param  Client  $owner
     */
    public function setOwner(Client $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param  string|null  $number
     */
    public function setNumber(?string $number): void
    {
        if ($number === null) {
            $number = $this->owner->getSsn() . '/' . date('Y-m-d-hsi');
        }
        $this->number = $number;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title'  => $this->getTitle(),
            'term'   => $this->getTerm(),
            'rate'   => $this->getRate(),
            'amount' => $this->getAmount(),
            'number' => $this->getNumber(),
            'status' => $this->status,
        ];
    }
}
