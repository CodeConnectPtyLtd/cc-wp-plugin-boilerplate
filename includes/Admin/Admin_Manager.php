<?php
namespace {{NAMESPACE}}\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin Manager
 */
class Admin_Manager {
    /**
     * Initialize Admin Hooks
     */
    public function init() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueue_assets( $hook ) {
        wp_enqueue_style(
            '{{TEXT_DOMAIN}}-admin',
            {{PREFIX}}_URL . 'admin/css/admin-style.css',
            array(),
            {{PREFIX}}_VERSION
        );

        wp_enqueue_script(
            '{{TEXT_DOMAIN}}-admin',
            {{PREFIX}}_URL . 'admin/js/admin-script.js',
            array( 'jquery' ),
            {{PREFIX}}_VERSION,
            true
        );
    }
}
