<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('dashicons_front')) {
    add_action('wp_enqueue_scripts', static function () {
            if ( ! is_user_logged_in()) {
                wp_deregister_style('dashicons');
            }
        }
        , 100);
}
