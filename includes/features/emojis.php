<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('disable_emojis')) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    add_filter('emoji_svg_url', '__return_false');

    add_filter('tiny_mce_plugins', static function ($plugins ) {
        return is_array($plugins ) ? array_diff($plugins, [ 'wpemoji']) : [];
    });
}
