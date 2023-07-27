<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;

/**
 * Class Company
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities
 */
class Company extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $name;
    /**
     * @var string
     */
    protected string $catchPhrase;
    /**
     * @var string
     */
    // phpcs:ignore Inpsyde.CodeQuality.ElementNameMinimalLength.TooShort
    protected string $bs;

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
    public function catchPhrase(): string
    {
        return $this->catchPhrase;
    }

    /**
     * @param string $catchPhrase
     */
    public function changeCatchPhrase(string $catchPhrase): void
    {
        $this->catchPhrase = $catchPhrase;
    }

    /**
     * @return string
     */
    // phpcs:ignore Inpsyde.CodeQuality.ElementNameMinimalLength.TooShort
    public function bs(): string
    {
        // phpcs:ignore Inpsyde.CodeQuality.ElementNameMinimalLength.TooShort
        return $this->bs;
    }

    /**
     * @param string $bs
     */
    // phpcs:ignore Inpsyde.CodeQuality.ElementNameMinimalLength.TooShort
    public function changeBs(string $bs): void
    {
        // phpcs:ignore Inpsyde.CodeQuality.ElementNameMinimalLength.TooShort
        $this->bs = $bs;
    }
}
