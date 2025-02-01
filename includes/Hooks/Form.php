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
		global $wpdb;
		$table_name = $wpdb->prefix . 'formbizz_submissions';

		// Decode JSON body
		$body = $param->get_body();
		$request = json_decode($body, true);

		// Check if request is empty
		if (empty($request)) {
			return new \WP_REST_Response([
				'success' => false,
				'message' => 'Request body cannot be empty'
			], 400);
		}

		// Insert into database
		$wpdb->insert($table_name, [
			'name'    => isset($request['name']) ? sanitize_text_field($request['name']) : '',
			'email'   => isset($request['email']) ? sanitize_email($request['email']) : '',
			'message' => isset($request['message']) ? sanitize_textarea_field($request['message']) : '',
		]);

		// Check if insert was successful
		if ($wpdb->last_error) {
			return new \WP_REST_Response([
				'success' => false,
				'message' => 'Database error: ' . $wpdb->last_error
			], 500);
		}

		// Return success response
		return new \WP_REST_Response([
			'success' => true,
			'message' => 'Data stored successfully',
			'data' => $request
		], 200);
	}
}