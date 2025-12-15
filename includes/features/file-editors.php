<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('file_editors')) {
    if ( ! defined('DISALLOW_FILE_EDIT')) {
        define('DISALLOW_FILE_EDIT', true);
    }
}