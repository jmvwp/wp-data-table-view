<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Renderer;

use MVWP\WPDataTableView\Admin\Settings;
use MVWP\WPDataTableView\PluginAPI;
use MVWP\WPDataTableView\RESTController;

/**
 * Class TemplateRenderer
 *
 * @package MVWP\WPDataTableView\Renderer
 */
class TemplateRenderer
{
    /**
     * @var Settings
     */
    private Settings $settings;
    /**
     * @var RESTController
     */
    private RESTController $restController;

    /**
     * @param Settings $settings
     * @param RESTController $restController
     */
    public function __construct(Settings $settings, RESTController $restController)
    {

        $this->settings = $settings;
        $this->restController = $restController;
    }

    /**
     * @return RESTController
     */
    public function restController(): RESTController
    {

        return $this->restController;
    }

    /**
     * @return Settings
     */
    public function settings(): Settings
    {

        return $this->settings;
    }

    /**
     * @return void
     */
    public function init()
    {

        add_action('init', [ $this, 'addCustomSlugEndpoint' ]);
        add_action('template_include', [ $this, 'addRenderTemplate' ]);
        add_action('wp_enqueue_scripts', [ $this, 'registerTemplateAssets' ]);
    }

    /**
     * @return void
     */
    public function addCustomSlugEndpoint()
    {

        $slug = $this->settings()->displayEndpoint();
        if ($slug) {
            add_rewrite_endpoint($slug, EP_ROOT, true);
        }
    }

    /**
     * @param string $template
     *
     * @return mixed|null
     */
    public function addRenderTemplate(string $template)
    {

        if ($this->isPageForRenderData()) {
            $template = $this->templatePath();
        }

        return $template;
    }

    /**
     * @return bool
     */
    public function isPageForRenderData(): bool
    {

        $slug = $this->settings()->displayEndpoint();
        $queryVar = get_query_var($slug, null);

        return $slug && ! $queryVar && ! is_null($queryVar);
    }

    /**
     * @return string
     */
    public function templatePath(): string
    {

        return apply_filters(
            MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'render_template_path',
            MVWP_WP_DATA_TABLE_VIEW_PLUGIN_DIR . '/templates/wp-users-table-template.php'
        );
    }

    /**
     * @return void
     */
    public function registerTemplateAssets()
    {

        if ($this->isPageForRenderData()) {
            if (! $this->settings()->isJsDisabled()) {
                wp_enqueue_script(
                    MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'js',
                    MVWP_WP_DATA_TABLE_VIEW_PLUGIN_URL . 'dist/main.min.js',
                    [],
                    MVWP_WP_DATA_TABLE_VIEW_VERSION,
                    true
                );
                $pluginJsSettings = [
                    'data' => [
                        'users' => PluginAPI::data(),
                        'columns' => [
                            [ 'key' => 'id', 'title' => __('Id', 'mvwp-wp-data-table-view') ],
                            [ 'key' => 'name', 'title' => __('Name', 'mvwp-wp-data-table-view') ],
                            [
                                'key' => 'username',
                                'title' => __('Username', 'mvwp-wp-data-table-view'),
                            ],
                        ],
                    ],
                    'rest' => [
                        'url' => esc_url_raw(rest_url()),
                        'nonce' => wp_create_nonce('wp_rest'),
                        'namespace' => $this->restController()->namespace(),
                        'rest_base' => $this->restController()->restBase(),
                    ],
                ];
                wp_add_inline_script(
                    MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'js',
                    'var mvwpWpDataTableView =' . json_encode($pluginJsSettings) . ';',
                    'before'
                );
            }
            if (! $this->settings()->isStylesDisabled()) {
                wp_enqueue_style(
                    MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'css',
                    MVWP_WP_DATA_TABLE_VIEW_PLUGIN_URL . 'dist/main.min.css',
                    [],
                    MVWP_WP_DATA_TABLE_VIEW_VERSION
                );
            }
        }
    }
}
