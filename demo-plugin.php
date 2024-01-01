<?php
/**
 * Plugin Name: Demo Plugin
 * Plugin URI:
 * Description: Demo plugin skeleton for WordPress with ReactJS.
 * Author: Sapayth H.
 * Author URI: https://sapayth.com
 * Version: 1.0.0
 * Text Domain: demo-plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

use WeDevs\WpUtils\ContainerTrait;
use WeDevs\WpUtils\SingletonTrait;

/**
 * Main bootstrap class for DemoPlugin
 */
final class DemoPlugin {
	use SingletonTrait, ContainerTrait;

	/**
	 * Minimum PHP version required
	 *
	 * @var string
	 */
	private $min_php = '7.4';

	/**
	 * Fire up the plugin
	 */
	public function __construct() {
		if ( ! $this->is_supported_php() ) {
			return;
		}

		$this->define_constants();

		$this->includes();
		$this->init_hooks();

		do_action( 'demo_plugin_loaded' );
	}

	public function define_constants() {
		$this->define( 'DEMO_PLUGIN_VERSION', '1.0.0' );
		$this->define( 'DEMO_PLUGIN_FILE', __FILE__ );
		$this->define( 'DEMO_PLUGIN_ROOT', __DIR__ );
		$this->define( 'DEMO_PLUGIN_ROOT_URI', plugins_url( '', __FILE__ ) );
		$this->define( 'DEMO_PLUGIN_ASSET_URI', DEMO_PLUGIN_ROOT_URI . '/assets' );
		$this->define( 'DEMO_PLUGIN_INCLUDES', DEMO_PLUGIN_ROOT . '/includes' );
	}

	private function define( $const, $value ) {
		if ( ! defined( $const ) ) {
			define( $const, $value );
		}
	}

	/**
	 * Initialize the hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'plugins_loaded', [ $this, 'instantiate' ] );
	}

	/**
	 * Instantiate the classes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function instantiate() {
		$this->assets = new DemoPlugin\Assets();
		$this->api    = new DemoPlugin\Api();

		if ( is_admin() ) {
			$this->admin = new DemoPlugin\Admin();
		}
	}

	/**
	 * Include the required files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		$helpers = DEMO_PLUGIN_ROOT . '/helpers/common-functions.php';


		if ( file_exists( $helpers ) ) {
			require_once $helpers;
		}
	}

	/**
	 * Check if the PHP version is supported
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_supported_php( $min_php = null ) {
		$min_php = $min_php ?: $this->min_php;

		if ( version_compare( PHP_VERSION, $min_php, '<=' ) ) {
			return false;
		}

		return true;
	}
}

/**
 * Returns the main instance of DemoPlugin
 *
 * @since 1.0.0
 *
 * @return DemoPlugin
 */
function DemoPlugin() {
	return DemoPlugin::instance();
}

DemoPlugin();