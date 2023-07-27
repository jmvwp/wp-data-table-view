<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Abstracts;

use MVWP\WPDataTableView\Interfaces\CacheInterface;

/**
 * Class AbstractProvider
 *
 * @package MVWP\WPDataTableView\Abstracts
 */
abstract class AbstractProvider
{
    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheInterface
     */
    protected function cacheService(): CacheInterface
    {
        return $this->cache;
    }

    /**
     * @return array
     */
    abstract public function allData(): array;

    /**
     * @param int $entryId
     *
     * @return array
     */
    abstract public function itemDataByID(int $entryId): array;
}
