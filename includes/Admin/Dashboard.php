<?php

namespace DemoPlugin\Admin;

class Dashboard {
	public function __construct() {
		add_action( 'demo_plugin_load_dashboard', [ $this, 'load_assets' ] );
	}

	public function load_assets() {
		wp_enqueue_style( 'demo-plugin-dashboard' );
		wp_enqueue_script( 'demo-plugin-dashboard' );

		wp_localize_script(
			'demo-plugin-dashboard',
			'demoPluginDashboard',
			[
				'nonce' => wp_create_nonce( 'wp_rest' ),
			]
		);
	}
}