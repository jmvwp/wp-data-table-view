<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;

/**
 * Class Geo
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities
 */
class Geo extends AbstractEntity
{
    protected float $lat;
    protected float $lng;

    /**
     * @return float
     */
    public function lat(): float
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function changeLat(string $lat): void
    {
        $this->lat = floatval($lat);
    }

    /**
     * @return float
     */
    public function lng(): float
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function changeLng(string $lng): void
    {
        $this->lng = floatval($lng);
    }
}
