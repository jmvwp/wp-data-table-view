<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

/**
 * Plugin Name: Wp Data Table View
 * Plugin URI: https://github.com/jmvwp/wp-data-table-view
 * Description: Wp Data Table View plugin to display 3rd party content in tables
 * Version: 1.0
 * Author: Maksym Viter
 * Author URI: https://github.com/jmvwp
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP: 8.0
 */

namespace MVWP\WPDataTableView;

use MVWP\WPDataTableView\Providers\DataRepository;

if (! defined("ABSPATH")) {
    exit;
}

/**
 * @return bool
 */
function checkPluginRequirements(): bool
{

    $minPhpVersion = '8.0';
    $currentPhpVersion = phpversion();
    if (! version_compare($currentPhpVersion, $minPhpVersion, '>=')) {
        adminNotice(
            sprintf(
                __(
                    'WP Data Table View plugin requires PHP version %1$1s or higher. You are running version %2$2s.',
                    'mvwp-wp-data-table-view'
                ),
                $minPhpVersion,
                $currentPhpVersion
            )
        );

        return false;
    }
    return true;
}

add_action(
    'plugins_loaded',
    static function () {
        require_once __DIR__ . '/config.php';
        load_plugin_textdomain('mvwp-wp-data-table-view');
        if (! checkPluginRequirements()) {
            return;
        }

        if (! class_exists(Plugin::class)) {
            /** @noinspection PhpIncludeInspection */
            require_once __DIR__ . '/vendor/autoload.php';
        }
        $container = include __DIR__ . "/di-config.php";
        $plugin = $container->get(Plugin::class);
        $plugin->init();
    }
);

/**
 * @param string $message
 */
function adminNotice(string $message): void
{

    $callback = static function () use ($message) {
        printf(
            '<div class="notice notice-error"><p>%1$s</p></div>',
            esc_html($message)
        );
    };

    add_action('admin_notices', $callback);
    add_action('network_admin_notices', $callback);
}

register_activation_hook(__FILE__, function () {
    set_transient('mvwp_flush_rewrite_rule_flag', '1');
});

add_action('admin_init',function (){
    if (get_transient('mvwp_flush_rewrite_rule_flag')) {
        flush_rewrite_rules();
    }
});

register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
});
