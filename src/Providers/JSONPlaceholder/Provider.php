<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView\Providers\JSONPlaceholder;

use MVWP\WPDataTableView\Abstracts\AbstractProvider;
use MVWP\WPDataTableView\Helpers;

/**
 * Class Provider
 *
 * @package MVWP\WPDataTableView\Providers\JSONPlaceholder
 */
class Provider extends AbstractProvider
{
    public const API_URL = 'https://jsonplaceholder.typicode.com';
    public const USERS_ENDPOINT = 'users';
    public const CACHE_KEY = 'json_placeholder_users';

    /**
     * @return array
     */
    public function allData(): array
    {

        $cachedData = $this->cacheService()->get(Provider::CACHE_KEY);
        if ($cachedData !== false) {
            return (array) $cachedData;
        }
        $data = $this->doGetRequest(Provider::USERS_ENDPOINT);
        if ($data) {
            $this->cacheService()->set(Provider::CACHE_KEY, $data);
        }

        return $data;
    }

    /**
     * @param int $entryId
     *
     * @return array
     */
    public function itemDataByID(int $entryId): array
    {

        $cachedData = $this->cacheService()->get(Provider::CACHE_KEY . $entryId);

        if ($cachedData !== false) {
            return (array) $cachedData;
        }
        $data = $this->doGetRequest(Provider::USERS_ENDPOINT . '/' . $entryId);
        if ($data) {
            $this->cacheService()->set(Provider::CACHE_KEY . $entryId, $data);
        }

        return $data;
    }

    /**
     * @param string $endpoint
     * @param array $args
     *
     * @return mixed
     */
    protected function doGetRequest(string $endpoint, array $args = []): array
    {

        $url = Provider::API_URL . '/' . $endpoint;
        if ($args) {
            $url = add_query_arg($args, $url);
        }
        $response = $this->handleResponse(wp_remote_get($url));
        if ($response) {
            return $response;
        }

        return [];
    }

    /**
     * @param $response
     *
     * @return array
     */
    // phpcs:ignore Inpsyde.CodeQuality.ArgumentTypeDeclaration.NoArgumentType
    protected function handleResponse($response): array
    {
        $data = [];
        if (is_wp_error($response)) {
            return $data;
        }
        $body = wp_remote_retrieve_body($response);
        $code = wp_remote_retrieve_response_code($response);
        $decodedJson = json_decode($body, true);
        if (Helpers::isResponseCode2xx($code) && json_last_error() === JSON_ERROR_NONE) {
            if (empty($decodedJson['error']) && is_array($decodedJson)) {
                $data = $decodedJson;
            }
        }

        return $data;
    }
}
