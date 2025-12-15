<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('embeds_disable')) {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    add_filter('embed_oembed_discover', '__return_false');
}