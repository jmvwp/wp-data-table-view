<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers;

use MVWP\WPDataTableView\Abstracts\AbstractEntity;
use MVWP\WPDataTableView\Abstracts\AbstractEntityFactory;
use MVWP\WPDataTableView\Abstracts\AbstractProvider;
use MVWP\WPDataTableView\Exceptions\EntityGenerationException;

/**
 * Class DataRepository
 *
 * @package MVWP\WPDataTableView\Providers
 */
class DataRepository
{
    /**
     * @var AbstractProvider
     */
    private AbstractProvider $provider;
    /**
     * @var AbstractEntityFactory
     */
    private AbstractEntityFactory $entityFactory;

    /**
     * @param AbstractProvider $provider
     * @param AbstractEntityFactory $entityFactory
     */
    public function __construct(AbstractProvider $provider, AbstractEntityFactory $entityFactory)
    {

        $this->provider = $provider;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @return AbstractEntity[]
     */
    public function all(): array
    {
        $result = [];
        $data = $this->providerService()->allData();
        if (! $data) {
            return $result;
        }
        foreach ($data as $datum) {
            try {
                $result[] = $this->entityFactory()->create($datum);
            } catch (EntityGenerationException $error) {
                return [];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function allForRender(): array
    {

        $result = [];
        $data = $this->providerService()->allData();
        if (! $data) {
            return $result;
        }

        foreach ($data as $datum) {
            try {
                $result[] = $this->entityFactory()->create($datum)->toArray();
            } catch (EntityGenerationException $error) {
                return [];
            }
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return AbstractEntity|null
     */
    public function entityById(int $id): ?AbstractEntity
    {

        $result = null;
        $data = $this->providerService()->itemDataByID($id);
        if ($data) {
            try {
                $result = $this->entityFactory()->create($data);
            } catch (EntityGenerationException $error) {
                return null;
            }
        }

        return $result;
    }

    /**
     * @return AbstractProvider
     */
    protected function providerService(): AbstractProvider
    {

        return $this->provider;
    }

    /**
     * @return AbstractEntityFactory
     */
    protected function entityFactory(): AbstractEntityFactory
    {

        return $this->entityFactory;
    }
}
