<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Abstracts;

use MVWP\WPDataTableView\Exceptions\EntityGenerationException;

/**
 * Class AbstractEntityFactory
 *
 * @package MVWP\WPDataTableView\Abstracts
 */
abstract class AbstractEntityFactory
{
    /**
     * @throws EntityGenerationException
     */
    public function create(array $data): AbstractEntity
    {

        $entity = $this->entity();
        $entity->populateFromArray($data);

        return $entity;
    }

    /**
     * @return AbstractEntity
     */
    abstract protected function entity(): AbstractEntity;
}
