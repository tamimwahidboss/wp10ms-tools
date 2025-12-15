<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('rss_disable')) {
    $callback =static function () {
        wp_die(esc_html__('Feeds are disabled on this site.', 'wp10ms-tools'), '', [ 'response'=> 404]);
    }

    ;
    add_action('do_feed', $callback, 1);
    add_action('do_feed_rdf', $callback, 1);
    add_action('do_feed_rss', $callback, 1);
    add_action('do_feed_rss2', $callback, 1);
    add_action('do_feed_atom', $callback, 1);
    add_action('do_feed_rss2_comments', $callback, 1);
    add_action('do_feed_atom_comments', $callback, 1);
}