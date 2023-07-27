<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use MVWP\WPDataTableView\Abstracts\AbstractProvider;
use MVWP\WPDataTableView\Admin\Settings;
use MVWP\WPDataTableView\Renderer\TemplateRenderer;

/**
 * Class Plugin
 *
 * @package MVWP\WPDataTableView
 */
final class Plugin
{
    /**
     * @var AbstractProvider
     */
    private AbstractProvider $dataProvider;
    /**
     * @var Settings
     */
    private Settings $settings;
    /**
     * @var RESTController
     */
    private RESTController $restController;
    /**
     * @var TemplateRenderer
     */
    private TemplateRenderer $templateRenderer;
    public const TMP_KEY_TO_FLUSH_REWRITE_RULES = MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'flush_rewrite_rules';

    /**
     * @param Settings $settings
     * @param AbstractProvider $dataProvider
     * @param RESTController $restController
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct(
        Settings $settings,
        AbstractProvider $dataProvider,
        RESTController $restController,
        TemplateRenderer $templateRenderer
    ) {

        $this->dataProvider = $dataProvider;
        $this->settings = $settings;
        $this->restController = $restController;
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * @return AbstractProvider
     */
    public function dataProvider(): AbstractProvider
    {
        return $this->dataProvider;
    }

    /**
     * @return Settings
     */
    public function settings(): Settings
    {
        return $this->settings;
    }

    /**
     * @return RESTController
     */
    public function restController(): RESTController
    {
        return $this->restController;
    }

    /**
     * @return TemplateRenderer
     */
    public function templateRenderer(): TemplateRenderer
    {
        return $this->templateRenderer;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $this->settings()->init();
        $this->templateRenderer()->init();
        add_action('rest_api_init', [ $this, 'restAPIInit' ]);
        add_action('update_option_' . $this->settings()->settingsKey(), [
            $this,
            'checkIfEndpointWasChanged',
        ], 10, 3);
        add_action('init', [ $this, 'mbFlushRewriteRules' ]);
    }

    /**
     * @return void
     */
    public function restAPIInit(): void
    {
        $this->restController()->register_routes();
    }
    /**
     * @param $oldValue
     * @param $value
     * @param $option
     *
     * @return void
     */
    // phpcs:ignore Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
    public function checkIfEndpointWasChanged($oldValue, $value, $option)
    {
        $endpointOptionKey = $this->settings()::OPTION_KEY_DISPLAY_ENDPOINT;
        $endpointWasChanged = false;
        if (isset($value[ $endpointOptionKey ]) && isset($oldValue[ $endpointOptionKey ])) {
            if ($value[ $endpointOptionKey ] !== $oldValue[ $endpointOptionKey ]) {
                $endpointWasChanged = true;
            }
        } elseif (
            (! isset($value[ $endpointOptionKey ]) && ! empty($oldValue[ $endpointOptionKey ])) ||
            (! isset($oldValue[ $endpointOptionKey ]) && ! empty($value[ $endpointOptionKey ]))
        ) {
            $endpointWasChanged = true;
        }
        if ($endpointWasChanged) {
            set_transient(Plugin::TMP_KEY_TO_FLUSH_REWRITE_RULES, '1');
        }
    }

    /**
     * @return void
     */
    public function mbFlushRewriteRules()
    {
        if (get_transient(Plugin::TMP_KEY_TO_FLUSH_REWRITE_RULES) === '1') {
            flush_rewrite_rules();
            delete_transient(Plugin::TMP_KEY_TO_FLUSH_REWRITE_RULES);
        }
    }
}
