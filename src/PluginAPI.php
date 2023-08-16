<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use MVWP\WPDataTableView\Providers\DataRepository;

/**
 * Class PluginAPI
 *
 * @package MVWP\WPDataTableView
 */
final class PluginAPI
{
    /**
     * @var DataRepository
     */
    private static DataRepository $dataRepository;

    /**
     * @param DataRepository $dataRepository
     *
     * @return void
     */
    public static function changeDataRepository(DataRepository $dataRepository)
    {

        if (! isset(self::$dataRepository)) {
            self::$dataRepository = $dataRepository;
        }
    }

    /**
     * @return Container
     */
    protected static function dataRepository(): DataRepository
    {

        return self::$dataRepository;
    }

    /**
     * @return array
     */
    public static function data(): array
    {
        try {
            $dataRepository = self::dataRepository();
        } catch (\Exception $error) {
            return [];
        }
        return $dataRepository->allForRender();
    }
}
