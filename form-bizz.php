<?php
/**
 * Plugin Name:       Form Bizz
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Iqbal Hossain
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       form-bizz
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Final Class for Form Bizz
 */

 final class FormBizz {
	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Instance of the FormBizz class.
	 *
	 * @var FormBizz
	 */
	private static $instance = null;

	/**
	 * Returns the instance of the class.
	 *
	 * @return FormBizz
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * FormBizz constructor.
	 */
	private function __construct() {
		// Plugins helper constants
		$this->helper_constants();

		// Load after plugin activation
		register_activation_hook( __FILE__, array( $this, 'activated_plugin' ) );

		// Make sure ADD AUTOLOAD is vendor/autoload.php file
		require_once FORMBIZZ_PLUGIN_DIR . 'vendor/autoload.php';

		// Load the plugin text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Plugin actions
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	/**
	 * Helper method for plugin constants.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function helper_constants() {
		define( 'FORMBIZZ_PLUGIN_VERSION', self::VERSION );
		define( 'FORMBIZZ_PLUGIN_NAME', 'FormBizz' );
		define( 'FORMBIZZ_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'FORMBIZZ_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * After activation hook method 
	 * add version to the options table if not exists yet and update the version if already exists.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function activated_plugin() {
		// update vertion to the options table
		update_option( 'formbizz_version', ELEMENTRIO_PLUGIN_VERSION );

		// added installed time after checking time exist or not
		if ( ! get_option( 'formbizz_installed_time' ) ) {
			add_option( 'formbizz_installed_time', time() );
		}

		// redirect to the settings page after activation
		add_option('formbizz_do_activation_redirect', true);
	}

	/**
	 * Plugins loaded method.
	 * loads our others classes and textdomain.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function plugins_loaded() { 
		/**
		 * Fires before the initialization of the Elementrio plugin.
		 *
		 * This action hook allows developers to perform additional tasks before the Elementrio plugin has been initialized.
		 * @since 1.0.0
		 */
		do_action( 'formBizz/before_init' );

		/**
		 * Action & Filter hooks.
		 *
		 * @return void
		 * @since 1.2.9
		 */
		FormBizz\Hooks\Init::instance();


		/**
		 * Action & Filter hooks.
		 *
		 * @return void
		 * @since 1.2.9
		 */
		FormBizz\Hooks\Form::instance();

		/**
		 * Fires after the initialization of the Elementrio plugin.
		 *
		 * This action hook allows developers to perform additional tasks after the Elementrio plugin has been initialized.
		 * @since 1.0.0
		 */
		do_action( 'formBizz/after_init' );
	}

	/**
	 * Loads the plugin text domain for the Elementrio Blocks Addon.
	 *
	 * This function is responsible for loading the translation files for the plugin.
	 * It sets the text domain to 'gutenkit-blocks-addon' and specifies the directory
	 * where the translation files are located.
	 *
	 * @param string $domain   The text domain for the plugin.
	 * @param bool   $network  Whether the plugin is network activated.
	 * @param string $directory The directory where the translation files are located.
	 * @return bool True on success, false on failure.
	 * @since 2.1.5
	 */
	public function load_textdomain() {
		/**
		 * Registers the block using the metadata loaded from the `block.json` file.
		 * Behind the scenes, it registers also all assets so they can be enqueued
		 * through the block editor in the corresponding context.
		 *
		 * @see https://developer.wordpress.org/reference/functions/register_block_type/
		 */
		register_block_type( __DIR__ . '/build/form' );

		// Load the plugin text domain
		load_plugin_textdomain( 'form-bizz', false, FORMBIZZ_PLUGIN_DIR . 'languages/' );
	}
 }

 FormBizz::instance();