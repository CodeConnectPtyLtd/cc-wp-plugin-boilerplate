<?php
namespace {{NAMESPACE}}\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Frontend Manager
 */
class Frontend_Manager {
    /**
     * Initialize Frontend Hooks
     */
    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Enqueue Frontend Assets
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            '{{TEXT_DOMAIN}}-frontend',
            {{PREFIX}}_URL . 'frontend/css/frontend-style.css',
            array(),
            {{PREFIX}}_VERSION
        );

        wp_enqueue_script(
            '{{TEXT_DOMAIN}}-frontend',
            {{PREFIX}}_URL . 'frontend/js/frontend-script.js',
            array( 'jquery' ),
            {{PREFIX}}_VERSION,
            true
        );
    }
}
