<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('use_block_editor_for_post', static function ($use, $post ) {
        return Plugin::instance()->enabled('classic_editor') ? false : $use;
    }

    , 10, 2);

add_filter('use_widgets_block_editor', static function ($use ) {
    return Plugin::instance()->enabled('classic_editor') ? false : $use;
});