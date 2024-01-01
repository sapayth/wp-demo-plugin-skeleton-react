<?php

namespace DemoPlugin\Api;

use DemoPlugin\Traits\RestResponseError;
use WP_REST_Server;
use Exception;

class Settings extends \WP_REST_Controller {

	use RestResponseError;

	/**
	 * The namespace of this controller's route.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $namespace = 'demo-plugin/v1';

	/**
	 * Route name
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $base = 'settings';

	/**
	 * Register routes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace, '/' . $this->base, [
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'permission_check' ],
				],
			]
		);

		register_rest_route(
			$this->namespace, '/' . $this->base . '/(?P<id>\d+)', [
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'edit_item' ],
					'permission_callback' => [ $this, 'permission_check' ],
				],
			]
		);
	}

	/**
	 * Retrieves a collection of settings
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function get_items( $request ) {}

	public function edit_item( $request ) {}

	/**
	 * Check permission for settings
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return bool
	 */
	public function permission_check() {
		return current_user_can( demo_plugin_get_admin_capability() );
	}
}