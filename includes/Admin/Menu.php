<?php

namespace DemoPlugin\Admin;

class Menu {
	private string $parent_slug;

	public function __construct() {
		$this->parent_slug = 'demo-plugin';

		add_action( 'admin_menu', [ $this, 'admin_menus' ] );
	}

	public function admin_menus() {
		$capability = demo_plugin_get_admin_capability();
		$menu_hook  = add_menu_page(
			__( 'Demo Plugin', 'demo-plugin' ), __( 'Demo Plugin', 'demo-plugin' ), $capability, $this->parent_slug,
			[ $this, 'render_dashboard' ]
		);

		add_action( 'load-' . $menu_hook, [ $this, 'dashboard_menu_action' ] );
	}

	public function dashboard_menu_action() {
		/**
		 * Backdoor for calling the menu hook.
		 * This hook won't get translated even the site language is changed
		 */
		do_action( 'demo_plugin_load_dashboard' );
	}

	public function render_dashboard() {
		echo '<div id="demo-plugin-dashboard"></div>';
	}
}
