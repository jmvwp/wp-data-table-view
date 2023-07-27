<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use DI\Container;
use MVWP\WPDataTableView\Providers\DataRepository;

/**
 * Class PluginAPI
 *
 * @package MVWP\WPDataTableView
 */
final class PluginAPI
{
    /**
     * @var Container
     */
    private static Container $container;

    /**
     * @param Container $container
     *
     * @return void
     */
    public static function changeContainer(Container $container)
    {

        if (! isset(self::$container)) {
            self::$container = $container;
        }
    }

    /**
     * @return Container
     */
    protected static function container(): Container
    {

        return self::$container;
    }

    /**
     * @return array
     */
    public static function data(): array
    {
        try {
            $dataRepository = self::container()->get(DataRepository::class);
        } catch (\Exception $error) {
            return [];
        }
        return $dataRepository->allForRender();
    }
}
