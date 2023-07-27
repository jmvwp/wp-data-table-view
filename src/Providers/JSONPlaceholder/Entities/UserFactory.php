<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;
use MVWP\WPDataTableView\Abstracts\AbstractEntityFactory;

/**
 * Class UserFactory
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities
 */
class UserFactory extends AbstractEntityFactory
{
    /**
     * @return AbstractEntity
     */
    protected function entity(): AbstractEntity
    {
        return new User();
    }
}
