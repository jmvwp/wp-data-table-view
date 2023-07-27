<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace MVWP\WPDataTableView;

use MVWP\WPDataTableView\Providers\DataRepository;
use WP_REST_Controller;

/**
 * Class RESTController
 *
 * @package MVWP\WPDataTableView
 */
class RESTController extends WP_REST_Controller
{
    /**
     * @var DataRepository
     */
    private DataRepository $dataRepository;

    /**
     * @param DataRepository $dataRepository
     */
    public function __construct(DataRepository $dataRepository)
    {
        $this->namespace = 'mvwp/v1';
        $this->rest_base = 'data-table-view';
        $this->dataRepository = $dataRepository;
    }

    /**
     * @return void
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function register_routes(): void
    {
        register_rest_route(
            $this->namespace,
            "/$this->rest_base/get-entity/(?P<id>[\d]+)",
            [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [ $this, 'entityById' ],
                'permission_callback' => [ $this, 'entityPermissionsCheck' ],
            ]
        );
    }

    /**
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public function entityById(\WP_REST_Request $request): \WP_REST_Response
    {
        $id = absint($request->get_param('id'));
        $data = null;
        $response = new \WP_REST_Response();
        if ($id) {
            $data = $this->dataRepository()->entityById($id);
        }
        if ($data) {
            $response->set_data($data->toArray());

            return $response;
        }
        $response->set_status(400);
        $response->set_data([ 'msg' => __('Invalid ID param', 'mvwp-wp-data-table-view') ]);

        return $response;
    }

    /**
     * @param \WP_REST_Request $request
     *
     * @return bool
     */
    public function entityPermissionsCheck(\WP_REST_Request $request): bool
    {
        return true;
    }

    /**
     * @return DataRepository
     */
    protected function dataRepository(): DataRepository
    {
        return $this->dataRepository;
    }

    /**
     * @return string
     */
    public function namespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function restBase(): string
    {
        return $this->rest_base;
    }
}
