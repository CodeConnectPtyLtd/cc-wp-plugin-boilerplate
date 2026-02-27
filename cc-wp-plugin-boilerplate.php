<?php
/**
 * Plugin Name:       {{PLUGIN_NAME}}
 * Plugin URI:        https://www.codeconnect.com.au/
 * Description:       {{DESCRIPTION}}
 * Version:           1.0.0
 * Author:            Code Connect
 * Author URI:        https://www.codeconnect.com.au/
 * License:           GPL v2 or later
 * Text Domain:       {{TEXT_DOMAIN}}
 * Domain Path:       /languages
 * WC requires at least: 6.0
 * WC tested up to: 9.1
 * WooCommerce High-Performance Order Storage: compatible
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Constants
 */
define( '{{PREFIX}}_VERSION', '1.0.0' );
define( '{{PREFIX}}_FILE', __FILE__ );
define( '{{PREFIX}}_PATH', plugin_dir_path( __FILE__ ) );
define( '{{PREFIX}}_URL', plugin_dir_url( __FILE__ ) );

/**
 * PSR-4 Autoloader
 */
spl_autoload_register( function ( $class ) {
    $prefix = '{{NAMESPACE}}\\';
    $base_dir = {{PREFIX}}_PATH . 'includes/';

    $len = strlen( $prefix );
    if ( strncmp( $prefix, $class, $len ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, $len );
    $file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

    if ( file_exists( $file ) ) {
        require $file;
    }
} );

/**
 * Initialize Plugin
 */
add_action( 'plugins_loaded', function() {
    if ( class_exists( '{{NAMESPACE}}\\Core' ) ) {
        $plugin = new {{NAMESPACE}}\\Core();
        $plugin->init();
    }
} );

/**
 * HPOS Compatibility
 */
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );
