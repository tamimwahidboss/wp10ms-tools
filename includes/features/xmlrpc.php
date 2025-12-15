<?php

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('xmlrpc_enabled', static function ($enabled ) {
    return Plugin::instance()->enabled('disable_xmlrpc') ? false : $enabled;
});