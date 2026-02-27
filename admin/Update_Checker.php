<?php

namespace {{NAMESPACE}}\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Update_Checker
 *
 * Handles plugin updates from the Code Connect distribution server.
 */
class Update_Checker {

    private $plugin_slug;
    private $plugin_file;
    private $update_url;
    private $version;

    /**
     * @param string $plugin_file Path to the main plugin file.
     * @param string $update_url  The base URL for the update server.
     */
    public function __construct( $plugin_file, $update_url ) {
        $this->plugin_file = $plugin_file;
        $this->plugin_slug = plugin_basename( $plugin_file );
        $this->update_url  = trailingslashit( $update_url ) . dirname( $this->plugin_slug ) . '/info.json';
        
        // Hook into the update transients
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_for_update' ) );
        add_filter( 'plugins_api', array( $this, 'get_plugin_info' ), 20, 3 );
    }

    /**
     * Get local version from plugin header.
     */
    private function get_local_version() {
        if ( isset( $this->version ) ) {
            return $this->version;
        }

        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugin_data   = get_plugin_data( $this->plugin_file );
        $this->version = $plugin_data['Version'];

        return $this->version;
    }

    /**
     * Check the remote server for a new version.
     */
    public function check_for_update( $transient ) {
        if ( empty( $transient->checked ) ) {
            return $transient;
        }

        $remote = $this->get_remote_info();

        if ( $remote && version_compare( $this->get_local_version(), $remote->version, '<' ) ) {
            $res = new \stdClass();
            $res->slug        = dirname( $this->plugin_slug );
            $res->plugin      = $this->plugin_slug;
            $res->new_version = $remote->version;
            $res->tested      = $remote->tested;
            $res->package     = $remote->download_url;
            $res->icons       = isset( $remote->icons ) ? (array) $remote->icons : array();
            $res->banners     = isset( $remote->banners ) ? (array) $remote->banners : array();

            $transient->response[ $this->plugin_slug ] = $res;
        }

        return $transient;
    }

    /**
     * Provide details for the "View details" popup.
     */
    public function get_plugin_info( $res, $action, $args ) {
        if ( 'plugin_information' !== $action || dirname( $this->plugin_slug ) !== $args->slug ) {
            return $res;
        }

        $remote = $this->get_remote_info();

        if ( ! $remote ) {
            return $res;
        }

        $res = new \stdClass();
        $res->name           = $remote->name;
        $res->slug           = $args->slug;
        $res->version        = $remote->version;
        $res->tested         = $remote->tested;
        $res->requires       = $remote->requires;
        $res->author         = $remote->author;
        $res->author_profile = $remote->author_profile;
        $res->download_link  = $remote->download_url;
        $res->trunk          = $remote->download_url;
        $res->last_updated   = $remote->last_updated;
        $res->sections       = (array) $remote->sections;

        return $res;
    }

    /**
     * Fetch the JSON from the remote server.
     */
    private function get_remote_info() {
        $remote = get_transient( 'cc_update_' . dirname( $this->plugin_slug ) );

        if ( false === $remote ) {
            $response = wp_remote_get( $this->update_url, array(
                'timeout' => 10,
                'headers' => array( 'Accept' => 'application/json' )
            ) );

            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                return false;
            }

            $remote = json_decode( wp_remote_retrieve_body( $response ) );
            
            if ( $remote ) {
                set_transient( 'cc_update_' . dirname( $this->plugin_slug ), $remote, HOUR_IN_SECONDS );
            }
        }

        return $remote;
    }
}
