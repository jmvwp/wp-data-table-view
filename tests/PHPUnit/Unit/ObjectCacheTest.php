<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Tests\Unit;

use MVWP\WPDataTableView\ObjectCache;
use Brain\Monkey\Functions;

class ObjectCacheTest extends AbstractUnitTestCase
{

    public function testSetAndGet()
    {

        if (! defined("MVWP_WP_DATA_TABLE_VIEW_PREFIX")) {
            define("MVWP_WP_DATA_TABLE_VIEW_PREFIX", 'mvwp_wp_data_table_view_');
        }
        Functions\expect('wp_cache_set')
            ->once()
            ->with('test_prefix_test_key', 'test_value', '', 900);
        Functions\expect('wp_cache_get')
            ->once()
            ->with('test_prefix_test_key')
            ->andReturn('test_value');
        Functions\expect('sanitize_key')
            ->with('test_key')
            ->andReturn('test_key');
        $cache = new ObjectCache('test_prefix_');
        $key = 'test_key';
        $value = 'test_value';

        $cache->set($key, $value);
        $retrievedValue = $cache->get($key);

        $this->assertEquals($value, $retrievedValue);
    }
}