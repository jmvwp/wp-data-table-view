<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;

/**
 * Class Address
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities
 */
class Address extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $street;
    /**
     * @var string
     */
    protected string $suite;
    /**
     * @var string
     */
    protected string $city;
    /**
     * @var string
     */
    protected string $zipcode;
    /**
     * @var Geo
     */
    protected Geo $geo;

    /**
     * @return string
     */
    public function street(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function changeStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function suite(): string
    {
        return $this->suite;
    }

    /**
     * @param string $suite
     */
    public function changeSuite(string $suite): void
    {
        $this->suite = $suite;
    }

    /**
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function changeCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function zipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function changeZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return Geo
     */
    public function geo(): Geo
    {
        return $this->geo;
    }

    /**
     * @param Geo $geo
     */
    public function changeGeo(Geo $geo): void
    {
        $this->geo = $geo;
    }
}
