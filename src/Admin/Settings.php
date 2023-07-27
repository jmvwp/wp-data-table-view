<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Admin;

use Jeffreyvr\WPSettings\WPSettings;

/**
 * Class Settings
 *
 * @package MVWP\WPDataTableView\Admin
 */
final class Settings
{
    /**
     * @var WPSettings
     */
    private WPSettings $settingsPage;
    /**
     * @var string
     */
    private string $defaultEndpoint;

    public const OPTION_KEY_DISPLAY_ENDPOINT = 'display_endpoint';
    public const OPTION_KEY_DISABLE_STYLES = 'disable_styles';
    public const OPTION_KEY_DISABLE_JS = 'disable_js';

    /**
     * @param WPSettings $settingsPage
     * @param string $defaultEndpoint
     */
    public function __construct(WPSettings $settingsPage, string $defaultEndpoint)
    {
        $this->settingsPage = $settingsPage;
        $this->defaultEndpoint = sanitize_title($defaultEndpoint);
    }

    /**
     * @return WPSettings
     */
    public function settingsPage(): WPSettings
    {
        return $this->settingsPage;
    }

    /**
     * @return string
     */
    public function settingsKey(): string
    {
        return $this->settingsPage()->option_name;
    }

    /**
     * @return void
     */
    public function init(): void
    {

        $section = $this->settingsPage
            ->add_section(__('General settings', 'mvwp-wp-data-table-view'));
        $section->add_option('text', [
            'name' => Settings::OPTION_KEY_DISPLAY_ENDPOINT,
            'label' => __(
                'Display endpoint (slug) (please don\'t use system or existing slugs)',
                'mvwp-wp-data-table-view'
            ),
            'sanitize' => static function (string $value): string {
                return sanitize_title($value);
            },
        ]);
        $section = $this->settingsPage
            ->add_section(__('Display settings', 'mvwp-wp-data-table-view'));
        $section->add_option('checkbox', [
            'name' => Settings::OPTION_KEY_DISABLE_STYLES,
            'label' => __('Disable plugin frontend CSS', 'mvwp-wp-data-table-view'),
        ]);
        $section->add_option('checkbox', [
            'name' => Settings::OPTION_KEY_DISABLE_JS,
            'label' => __('Disable plugin frontend JS', 'mvwp-wp-data-table-view'),
        ]);
        $this->settingsPage->make();
    }

    /**
     * @return string
     */
    public function displayEndpoint(): string
    {
        $options = $this->settingsPage->get_options();
        $endpoint = ! empty($options[ Settings::OPTION_KEY_DISPLAY_ENDPOINT ]) ?
            sanitize_title($options[ Settings::OPTION_KEY_DISPLAY_ENDPOINT ]) :
            $this->defaultEndpoint;

        return apply_filters(MVWP_WP_DATA_TABLE_VIEW_PREFIX . 'display_endpoint', $endpoint);
    }

    /**
     * @return bool
     */
    public function isStylesDisabled(): bool
    {
        $options = $this->settingsPage->get_options();

        return ! empty($options[ Settings::OPTION_KEY_DISABLE_STYLES ]) &&
               ! ! $options[ Settings::OPTION_KEY_DISABLE_STYLES ];
    }

    /**
     * @return bool
     */
    public function isJsDisabled(): bool
    {
        $options = $this->settingsPage->get_options();

        return ! empty($options[ Settings::OPTION_KEY_DISABLE_JS ]) && ! ! $options[ Settings::OPTION_KEY_DISABLE_JS ];
    }
}
