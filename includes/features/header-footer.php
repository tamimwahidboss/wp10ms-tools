<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_action('wp_head', static function () {
    $p =Plugin::instance();
    $raw =(string) $p->get('header_scripts', '');

    if ('' !==trim($raw )) {
        echo "\n<!-- WP10MSTools Header Scripts -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo wp_kses_post( $raw ); // Allow HTML/JS per sanitize rules. phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo "\n<!-- /WP10MSTools Header Scripts -->\n";
    }
}

, 999);

add_action('wp_footer', static function () {
    $p =Plugin::instance();
    $raw =(string) $p->get('footer_scripts', '');

    if ('' !==trim($raw )) {
        echo "\n<!-- WP10MSTools Footer Scripts -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo wp_kses_post( $raw ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo "\n<!-- /WP10MSTools Footer Scripts -->\n";
    }
} , 999);