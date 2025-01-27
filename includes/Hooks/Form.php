<?php
namespace FormBizz\Hooks;

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue registrar.
 *
 * @since 1.0.0
 * @access public
 */
class Form {

	use \FormBizz\Traits\Singleton;

	/**
	 * class constructor.
	 * private for singleton
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('rest_api_init', array($this, 'formbizz_post_data'));
	}

	// Register the rest api route
	public function formbizz_post_data()
	{
		register_rest_route(
			'formbizz/v1',
			'/form/data',
			array(
				'methods' => 'POST',
				'callback' => array($this, 'formbizz_post_callback'),
				'permission_callback' => '__return_true',
			)
		);
	}

	// Rest api callback
	public function formbizz_post_callback($param)
	{
		$body = $param->get_body();
		$request = json_decode($body, true);

		error_log(print_r($request, true));

		// Process the request data and return a response
		$response = array(
			'success' => true,
			'data' => $request,
		);

		return new \WP_REST_Response($response, 200);
	}
}