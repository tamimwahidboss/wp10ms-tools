<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

if (Plugin::instance()->enabled('self_pingbacks')) {
    add_action('pre_ping', static function (array &$links ) {
            $home =home_url();

            foreach ($links as $k => $link ) {
                if (0===strpos($link, $home )) {
                    unset($links[ $k ]);
                }
            }
        });
}
