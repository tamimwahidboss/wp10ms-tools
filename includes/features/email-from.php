<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('wp_mail_from', static function ($addr ) {
    $p =Plugin::instance();
    $v =sanitize_email((string) $p->get('email_from_address', ''));
    return $v ? $v : $addr;
});

add_filter('wp_mail_from_name', static function ($name ) {
    $p =Plugin::instance();
    $v =sanitize_text_field((string) $p->get('email_from_name', ''));
    return $v ? $v : $name;
});