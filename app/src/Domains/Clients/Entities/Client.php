<?php

declare(strict_types=1);

namespace App\Domains\Clients\Entities;

use App\Domains\Clients\ValueObjects\Address;
use App\Domains\Clients\ValueObjects\Name;

class Client
{
    private Name $name;
    private int $age;
    private Address $address;
    private string $ssn;
    private int $fico;
    private int $income;
    private string $email;
    private string $phone;


    private function __construct(array $data)
    {
        $this->setName($data['first_name'], $data['last_name']);
        $this->setAge($data['age']);
        $this->setAddress($data['city'], $data['state'], $data['zip']);
        $this->setSsn($data['ssn']);
        $this->setFico($data['fico']);
        $this->setIncome($data['income']);
        $this->setEmail($data['email']);
        $this->setPhone($data['phone']);
    }

    /**
     * @param  array  $date
     * @return static
     */
    public static function create(array $date): self
    {
        return new self($date);
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @param  string  $firstName
     * @param  string  $lastName
     */
    public function setName(string $firstName, string $lastName): void
    {
        $this->name = new Name($firstName, $lastName);
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param  mixed  $age
     */
    public function setAge(mixed $age): void
    {
        $this->age = (int) $age;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param  string  $city
     * @param  string  $state
     * @param  string  $zip
     */
    public function setAddress(string $city, string $state, string $zip): void
    {
        $this->address = new Address($city, $state, $zip);
    }

    /**
     * @return string
     */
    public function getSsn(): string
    {
        return $this->ssn;
    }

    /**
     * @param  string  $ssn
     */
    public function setSsn(string $ssn): void
    {
        $this->ssn = $ssn;
    }

    /**
     * @return int
     */
    public function getFico(): int
    {
        return $this->fico;
    }

    /**
     * @param  mixed  $fico
     */
    public function setFico(mixed $fico): void
    {
        $this->fico = (int) $fico;
    }

    /**
     * @return int
     */
    public function getIncome(): int
    {
        return $this->income;
    }

    /**
     * @param  mixed  $income
     */
    public function setIncome(mixed $income): void
    {
        $this->income = (int) $income;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param  string  $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function toArray()
    {
        return [
            'name'    => [
                'first_name' => $this->getName()->getFirstName(),
                'last_name'  => $this->getName()->getLastName(),
            ],
            'age'     => $this->getAge(),
            'address' => [
                'city'  => $this->getAddress()->getCity(),
                'state' => $this->getAddress()->getState(),
                'zip'   => $this->getAddress()->getZip(),
            ],
            'ssn' => $this->getSsn(),
            'fico' => $this->getFico(),
            'income' => $this->getIncome(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
        ];
    }
}
