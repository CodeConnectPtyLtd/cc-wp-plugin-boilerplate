<?php
namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Core Plugin Class
 */
class Core {
    /**
     * Initialize all components
     */
    public function init() {
        // Load Admin components
        if ( is_admin() ) {
            $this->init_admin();
        }

        // Load Frontend components
        $this->init_frontend();

        // Common hooks
        $this->register_hooks();
    }

    private function init_admin() {
        $admin = new Admin\Admin_Manager();
        $admin->init();
    }

    private function init_frontend() {
        $frontend = new Frontend\Frontend_Manager();
        $frontend->init();
    }

    private function register_hooks() {
        // Register common hooks
    }
}
