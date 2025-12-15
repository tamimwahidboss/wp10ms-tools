<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('rest_authentication_errors', static function ($result ) {
    $p =Plugin::instance();

    if ($p->enabled('disable_rest_api') && ! is_user_logged_in()) {
        return new WP_Error('rest_forbidden', __('REST API restricted to logged-in users.', 'wp10ms-tools'), [ 'status'=> 401]);
    }

    return $result;
});