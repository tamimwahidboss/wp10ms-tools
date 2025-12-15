<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('jquery_migrate')) {
    add_action('wp_default_scripts', static function ($scripts ) {
        if ( ! empty($scripts->registered['jquery'])) {
            $deps =$scripts->registered['jquery']->deps;
            $scripts->registered['jquery']->deps=array_diff($deps, [ 'jquery-migrate']);
        }
    });
}