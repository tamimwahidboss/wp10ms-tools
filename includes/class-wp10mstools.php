<?php

namespace WP10MSTools;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin {
    private static $instance = null;

    /** Option key to store all settings. */
    const OPTION_KEY = 'wp10mstools_options';

    /** Cached options. */
    private $options = [];

    public static function instance(): self {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->options = get_option( self::OPTION_KEY, [] ); 

        // Admin part.
        if ( is_admin() ) {
            require_once WP10MSTOOLS_DIR . 'includes/admin/class-wp10mstools-admin.php';
            Admin::instance( $this );
        }

        // Load features (always load files, each file will check if enabled before acting).
        $this->load_feature( 'uploads' );
        $this->load_feature( 'remove-wp-version' );
        $this->load_feature( 'xmlrpc' );
        $this->load_feature( 'rest-api' );
        $this->load_feature( 'classic-editor' );
        $this->load_feature( 'admin-bar' );
        $this->load_feature( 'header-footer' );
        $this->load_feature( 'emojis' );
        $this->load_feature( 'shortcodes-in-widgets' );
        $this->load_feature( 'email-from' );
        // Extra recommended goodies:
        $this->load_feature( 'embeds' );
        $this->load_feature( 'file-editors' );
        $this->load_feature( 'revisions' );
        $this->load_feature( 'dashicons' );
        $this->load_feature( 'jquery-migrate' );
        $this->load_feature( 'self-pingbacks' );
        $this->load_feature( 'clean-head' );
        $this->load_feature( 'rss-feeds' );
    }

    private function load_feature( string $feature ): void {
        $path = WP10MSTOOLS_DIR . 'includes/features/' . $feature . '.php';
        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }

    /** Return full options array. */
    public function options(): array {
        if ( ! is_array( $this->options ) ) {
            $this->options = [];
        }
        return $this->options;
    }

    /** Check if a boolean feature is enabled. */
    public function enabled( string $key ): bool {
        $opts = $this->options();
        return ! empty( $opts[ $key ] );
    }

    /** Get a raw option value (string/int). */
    public function get( string $key, $default = '' ) {
        $opts = $this->options();
        return $opts[ $key ] ?? $default;
    }
}