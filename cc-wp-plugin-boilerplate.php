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
    $len = strlen( $prefix );

    if ( strncmp( $prefix, $class, $len ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, $len );
    
    // Map namespaces to root folders for Admin and Frontend
    if ( strpos( $relative_class, 'Admin\\' ) === 0 ) {
        $file = {{PREFIX}}_PATH . str_replace( '\\', '/', $relative_class ) . '.php';
    } elseif ( strpos( $relative_class, 'Frontend\\' ) === 0 ) {
        $file = {{PREFIX}}_PATH . str_replace( '\\', '/', $relative_class ) . '.php';
    } else {
        $file = {{PREFIX}}_PATH . 'includes/' . str_replace( '\\', '/', $relative_class ) . '.php';
    }

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

    // Initialize Update Checker (outside is_admin so it runs during WP cron)
    if ( class_exists( '{{NAMESPACE}}\\Admin\\Update_Checker' ) ) {
        new {{NAMESPACE}}\\Admin\\Update_Checker(
            __FILE__,
            'https://plugins.code-connect.com.au/wp-content/uploads/plugin-distribution/'
        );
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
