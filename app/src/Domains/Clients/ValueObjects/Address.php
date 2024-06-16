<?php

declare(strict_types=1);

namespace App\Domains\Clients\ValueObjects;

final class Address
{
    private string $city;
    private string $state;
    private string $zip;

    public function __construct(string $city, string $state, string $zip)
    {
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }
}
