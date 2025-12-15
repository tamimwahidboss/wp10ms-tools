<?php

/**
 * Plugin Name: WP10MS Tools
 * Plugin URI: https://wordpress.org/plugins/ 
 * Description: WP10MS Tools provides essential tweaks and utilities for WordPress – webp, svg, uploads, fonts, utility, security, performance, and customization in one lightweight plugin.
 * Version:     1.0.0
 * Author:      tamimwahid
 * Author URI: https://github.com/tamimwahidboss/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp10ms-tools
 * Domain Path: /languages
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // No direct access.
}

// Plugin constants.
if ( ! defined( 'WP10MSTOOLS_VERSION' ) ) {
    define( 'WP10MSTOOLS_VERSION', '1.0.0' );
}
if ( ! defined( 'WP10MSTOOLS_FILE' ) ) {
    define( 'WP10MSTOOLS_FILE', __FILE__ );
}
if ( ! defined( 'WP10MSTOOLS_DIR' ) ) {
    define( 'WP10MSTOOLS_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WP10MSTOOLS_URL' ) ) {
    define( 'WP10MSTOOLS_URL', plugin_dir_url( __FILE__ ) );
}

// Load core.
require_once WP10MSTOOLS_DIR . 'includes/class-wp10mstools.php';

// Bootstrap.
add_action( 'plugins_loaded', static function () {
    \WP10MSTools\Plugin::instance();
} );
