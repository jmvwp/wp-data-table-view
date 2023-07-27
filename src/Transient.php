<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use MVWP\WPDataTableView\Interfaces\CacheInterface;

/**
 * Class Transient
 *
 * @package MVWP\WPDataTableView
 */
class Transient implements CacheInterface
{
    public const DEFAULT_CACHE_EXPIRATION = 60 * 15;
    /**
     * @var string
     */
    private string $prefix;

    /**
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function get(string $key)
    {
        return get_transient($this->prepareKey($key));
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return void
     */
    public function set(string $key, $value): void
    {
        set_transient($this->prepareKey($key), $value, $this->expiration());
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function prepareKey(string $key): string
    {

        return $this->prefix . sanitize_key($key);
    }

    /**
     * @return int
     */
    protected function expiration(): int
    {

        return absint(
            apply_filters(
                MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'cache_expiration',
                Transient::DEFAULT_CACHE_EXPIRATION
            )
        );
    }
}
