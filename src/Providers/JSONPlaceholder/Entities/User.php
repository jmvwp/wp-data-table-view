<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;

/**
 * Class User
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities
 */
class User extends AbstractEntity
{
    /**
     * @var int
     */
    protected int $id;
    /**
     * @var string
     */
    protected string $name;
    /**
     * @var string
     */
    protected string $username;
    /**
     * @var string
     */
    protected string $email;
    /**
     * @var string
     */
    protected string $phone;
    /**
     * @var string
     */
    protected string $website;
    /**
     * @var Address
     */
    protected Address $address;
    /**
     * @var Company
     */
    protected Company $company;

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function changeId(string $id): void
    {
        $this->id = absint($id);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function changeUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function changeEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function phone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function changePhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function website(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function changeWebsite(string $website): void
    {
        $this->website = $website;
    }

    /**
     * @return Address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function changeAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Company
     */
    public function company(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function changeCompany(Company $company): void
    {
        $this->company = $company;
    }
}
