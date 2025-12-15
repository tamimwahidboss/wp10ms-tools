<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

$limit =(int) WP10MSTools\Plugin::instance()->get('limit_revisions', 0);

if ($limit >=0) {
    add_filter('wp_revisions_to_keep', static function ($num, $post ) use ($limit ) {
            return $limit; // 0 disables revisions; choose wisely.
        }

        , 10, 2);
}