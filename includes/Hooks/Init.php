<?php
namespace FormBizz\Hooks;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue registrar.
 *
 * @since 1.0.0
 * @access public
 */
class Init {

	use \FormBizz\Traits\Singleton;

	/**
	 * class constructor.
	 * private for singleton
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		// Enqueue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueues necessary scripts and localizes data for the admin area.
	 *
	 * @param string $hook The current page.
	 * @return void
	 * @since 1.0.0
	 */
	public function admin_scripts( $hook ) {
		wp_localize_script(
			'wp-block-editor',
			'formbizz',
			array(
				'root_url'		=> esc_url( home_url( '/' ) ),
				'version'     => FORMBIZZ_PLUGIN_VERSION,
				'activeTheme' => wp_get_theme()->get('Name'),
			)
		);
	}
}