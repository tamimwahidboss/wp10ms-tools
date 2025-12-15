<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('shortcodes_in_widgets')) {
    add_filter('widget_text', 'do_shortcode');
}