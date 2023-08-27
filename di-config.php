<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use DI\ContainerBuilder;
use Jeffreyvr\WPSettings\WPSettings;
use MVWP\WPDataTableView\Abstracts\AbstractEntityFactory;
use MVWP\WPDataTableView\Abstracts\AbstractProvider;
use MVWP\WPDataTableView\Admin\Settings;
use MVWP\WPDataTableView\Interfaces\CacheInterface;
use MVWP\WPDataTableView\Providers\DataRepository;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Entities\UserFactory;
use MVWP\WPDataTableView\Providers\JSONPlaceholder\Provider;
use MVWP\WPDataTableView\Renderer\TemplateRenderer;

use function DI\autowire;

$containerBuilder = new ContainerBuilder();
$cache = wp_using_ext_object_cache() ? ObjectCache::class : Transient::class;
$containerBuilder->addDefinitions([
    Plugin::class => autowire(Plugin::class),
    AbstractProvider::class => autowire(Provider::class),
    RESTController::class => autowire(RESTController::class),
    Settings::class => autowire(Settings::class)
        ->constructorParameter('defaultEndpoint', MVWP_WP_DATA_TABLE_VIEW_DEFAULT_ENDPOINT),
    WPSettings::class => autowire(WPSettings::class)
        ->constructorParameter(
            'title',
            __('WP Data Table View Settings', 'mvwp-wp-data-table-view')
        ),
    DataRepository::class => autowire(DataRepository::class),
    AbstractEntityFactory::class => autowire(UserFactory::class),
    CacheInterface::class => autowire($cache)
        ->constructorParameter('prefix', MVWP_WP_DATA_TABLE_VIEW_PREFIX),
    TemplateRenderer::class => autowire(TemplateRenderer::class),
]);

$container = $containerBuilder->build();

return $container;
