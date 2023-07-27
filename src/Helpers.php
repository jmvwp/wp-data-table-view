<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

/**
 * Class Helpers
 *
 * @package MVWP\WPDataTableView
 */
class Helpers
{
    /**
     * @param int $code
     *
     * @return bool
     */
    public static function isResponseCode2xx(int $code): bool
    {
        return $code >= 200 && $code < 300;
    }
}
