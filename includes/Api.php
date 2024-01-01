<?php

namespace DemoPlugin;


use DemoPlugin\Api\Settings;
use WeDevs\WpUtils\ContainerTrait;

class Api {
	use ContainerTrait;

	public function __construct() {
		$this->settings = new Settings();

		add_action( 'rest_api_init', [ $this, 'init_api' ] );
	}

	public function init_api() {
		foreach ( $this->container as $class ) {
			$object = new $class();
			$object->register_routes();
		}
	}
}