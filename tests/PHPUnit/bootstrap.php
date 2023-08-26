<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

$vendor = dirname(dirname(dirname(__FILE__))) . '/vendor/';

if (! realpath($vendor)) {
    die('Please install via Composer before running tests.');
}
if (! defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', $vendor . 'autoload.php');
}
if (! defined('PHPUNIT_FIXTURES_PATH')) {
    define('PHPUNIT_FIXTURES_PATH', __DIR__ . '/Unit/fixtures/');
}

require_once $vendor . '/antecedent/patchwork/Patchwork.php';
require_once $vendor . 'autoload.php';
unset($vendor);

