<?php

namespace DemoPlugin;

class Assets {
	/**
	 * Suffix for the scripts. add `.min` if we are in production
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $suffix;

	public function __construct() {
		$this->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		add_action( 'init', [ $this, 'register_all_scripts' ] );
	}

	/**
	 * Register all the css and js from here
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_all_scripts() {
		$styles  = $this->get_styles();
		$scripts = $this->get_scripts();
		do_action( 'demo_plugin_before_register_scripts', $scripts, $styles );
		$this->register_styles( $styles );
		$this->register_scripts( $scripts );
		do_action( 'demo_plugin_after_register_scripts', $scripts, $styles );
	}

	/**
	 * Register the CSS from here. Need to define the JS first from get_styles()
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_styles( $styles ) {
		foreach ( $styles as $handle => $style ) {
			$deps    = ! empty( $style['deps'] ) ? $style['deps'] : [];
			$version = ! empty( $style['version'] ) ? $style['version'] : DEMO_PLUGIN_VERSION;
			$media   = ! empty( $style['media'] ) ? $style['media'] : 'all';

			wp_register_style( 'demo-plugin-' . $handle, $style['src'], $deps, $version, $media );
		}
	}

	/**
	 * Register the JS from here. Need to define the JS first from get_scripts()
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_scripts( $scripts ) {
		foreach ( $scripts as $handle => $script ) {
			$deps      = ! empty( $script['deps'] ) ? $script['deps'] : [];
			$in_footer = ! empty( $script['in_footer'] ) ? $script['in_footer'] : true;
			$version   = ! empty( $script['version'] ) ? $script['version'] : DEMO_PLUGIN_VERSION;

			wp_register_script( 'demo-plugin-' . $handle, $script['src'], $deps, $version, $in_footer );
		}
	}

	/**
	 * Returns the list of styles
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|null
	 */
	public function get_styles() {
		return [
			'dashboard' => [
				'src' => DEMO_PLUGIN_ASSET_URI . '/css/dashboard-css.css',
			],
		];
	}

	/**
	 * Returns the list of JS
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|null
	 */
	public function get_scripts() {
		$scripts = [
			'dashboard' => [
				'src'       => DEMO_PLUGIN_ASSET_URI . '/js/dashboard-js' . $this->suffix . '.js',
				'in_footer' => true,
			],
		];

		return $scripts;
	}
}
