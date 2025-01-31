<?php
namespace FormBizz\Hooks;

defined('ABSPATH') || exit;

class Admin {
	use \FormBizz\Traits\Singleton;

    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu']);
    }

    public function register_menu() {
        add_menu_page(
            'Form Bizz Submissions',
            'Form Bizz',
            'manage_options',
            'formbizz-submissions',
            [$this, 'render_submissions_page'],
            'dashicons-email-alt',
            25
        );
    }

    public function render_submissions_page() {
        require_once __DIR__ . '/../templates/admin-page.php';
    }
}
