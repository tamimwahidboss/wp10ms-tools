<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('show_admin_bar', static function ($show ) {
    $p =Plugin::instance();

    if ($p->enabled('admin_bar_non_admin') && ! current_user_can('manage_options')) {
        return false;
    }

    return $show;
});