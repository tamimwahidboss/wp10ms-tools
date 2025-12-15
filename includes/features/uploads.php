<?php 

use WP10MSTools\Plugin;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('upload_mimes', static function ($mimes ) {
    $p =Plugin::instance();

    if ($p->enabled('allow_svg')) {
        $mimes['svg']='image/svg+xml';
    }

    if ($p->enabled('allow_fonts')) {
        $mimes['ttf']='font/ttf';
        $mimes['woff']='font/woff';
        $mimes['woff2']='font/woff2';
    }

    if ($p->enabled('allow_webp')) {
        $mimes['webp']='image/webp';
    }

    return $mimes;
});

// Optional: sanitize SVG upload (basic). For real SVG security, use a sanitizer library.
add_filter('wp_check_filetype_and_ext', static function ($types, $file, $filename, $mimes ) {
    $p =Plugin::instance();

    if ($p->enabled('allow_svg') && 'svg'===strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        $types['ext']='svg';
        $types['type']='image/svg+xml';
    }

    return $types;
} , 10, 4);

// 1. Allow .ico files in the mime types list
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['ico'] = 'image/x-icon';
    return $mimes;
} );

// 2. Bypass filetype check for .ico specifically
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes, $real_mime ) {
    if ( substr( $filename, -4 ) === '.ico' ) {
        $data['ext']  = 'ico';
        $data['type'] = 'image/x-icon';
    }
    return $data;
}, 10, 5 );
