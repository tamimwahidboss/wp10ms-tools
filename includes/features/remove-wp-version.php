<?php

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('the_generator', static function ($gen ) {
    return Plugin::instance()->enabled('remove_wp_version') ? '' : $gen;
});