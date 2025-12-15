<?php

namespace WP10MSTools;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin {
    private static $instance;
    private $plugin;

    public static function instance( Plugin $plugin ): self {
        if ( null === self::$instance ) {
            self::$instance = new self( $plugin );
        }
        return self::$instance;
    }

    private function __construct( Plugin $plugin ) {
        $this->plugin = $plugin;

        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
    }

    public function assets( $hook ) {
        if ( 'settings_page_wp10mstools' !== $hook ) {
            return;
        }
        wp_enqueue_style( 'wp10mstools-admin', WP10MSTOOLS_URL . 'assets/admin.css', [], WP10MSTOOLS_VERSION );
        wp_enqueue_script( 'wp10mstools-admin', WP10MSTOOLS_URL . 'assets/admin.js', [ 'jquery' ], WP10MSTOOLS_VERSION, true );
    }

    public function menu(): void {
        add_options_page(
            __( 'WP10MS Tools', 'wp10ms-tools' ),
            __( 'WP10MS Tools', 'wp10ms-tools' ),
            'manage_options',
            'wp10mstools',
            [ $this, 'render' ]
        );
    }

    /**
     * Register settings using the Settings API.
     */
    public function register_settings(): void {
        register_setting( 'wp10mstools_settings', Plugin::OPTION_KEY, [ $this, 'sanitize' ] );

        add_settings_section( 'wp10mstools_core', __( 'Core Tweaks', 'wp10ms-tools' ), '__return_false', 'wp10mstools' );
        add_settings_section( 'wp10mstools_security', __( 'Security', 'wp10ms-tools' ), '__return_false', 'wp10mstools' );
        add_settings_section( 'wp10mstools_perf', __( 'Performance', 'wp10ms-tools' ), '__return_false', 'wp10mstools' );
        add_settings_section( 'wp10mstools_custom', __( 'Customization', 'wp10ms-tools' ), '__return_false', 'wp10mstools' );

        // Define fields: key => [label, section, type]
        $fields = $this->fields();
        foreach ( $fields as $key => $field ) {
            add_settings_field(
                $key,
                esc_html( $field['label'] ),
                [ $this, 'field_callback' ],
                'wp10mstools',
                $field['section'],
                [ 'key' => $key, 'field' => $field ]
            );
        }
    }

    public function fields(): array { 
        return [
            // Core tweaks.
            'allow_svg'                => [ 'label' => __( 'Enable SVG uploads', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'allow_fonts'              => [ 'label' => __( 'Enable WOFF/TTF uploads', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'allow_webp'               => [ 'label' => __( 'Enable WebP uploads', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'allow_ico'                => [ 'label' => __( 'Enable Ico uploads', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'remove_wp_version'        => [ 'label' => __( 'Remove WordPress version from HTML', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'shortcodes_in_widgets'    => [ 'label' => __( 'Enable shortcodes in widgets', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],
            'classic_editor'           => [ 'label' => __( 'Disable Gutenberg (use Classic Editor)', 'wp10ms-tools' ), 'section' => 'wp10mstools_core', 'type' => 'checkbox' ],

            // Security.
            'disable_xmlrpc'           => [ 'label' => __( 'Disable XML-RPC', 'wp10ms-tools' ), 'section' => 'wp10mstools_security', 'type' => 'checkbox' ],
            'disable_rest_api'         => [ 'label' => __( 'Disable REST API for non-logged-in users', 'wp10ms-tools' ), 'section' => 'wp10mstools_security', 'type' => 'checkbox' ],
            'file_editors'             => [ 'label' => __( 'Disable plugin/theme file editors', 'wp10ms-tools' ), 'section' => 'wp10mstools_security', 'type' => 'checkbox' ],
            'rss_disable'              => [ 'label' => __( 'Disable RSS/Atom feeds', 'wp10ms-tools' ), 'section' => 'wp10mstools_security', 'type' => 'checkbox' ],

            // Performance.
            'disable_emojis'           => [ 'label' => __( 'Remove emoji scripts/styles', 'wp10ms-tools' ), 'section' => 'wp10mstools_perf', 'type' => 'checkbox' ],
            'embeds_disable'           => [ 'label' => __( 'Disable oEmbed/Embeds', 'wp10ms-tools' ), 'section' => 'wp10mstools_perf', 'type' => 'checkbox' ],
            'dashicons_front'          => [ 'label' => __( 'Remove Dashicons for non-logged-in visitors', 'wp10ms-tools' ), 'section' => 'wp10mstools_perf', 'type' => 'checkbox' ],
            'jquery_migrate'           => [ 'label' => __( 'Dequeue jQuery Migrate on frontend', 'wp10ms-tools' ), 'section' => 'wp10mstools_perf', 'type' => 'checkbox' ],
            'limit_revisions'          => [ 'label' => __( 'Limit post revisions (0–50)', 'wp10ms-tools' ), 'section' => 'wp10mstools_perf', 'type' => 'number', 'min' => 0, 'max' => 50 ],

            // Customization / UX.
            'admin_bar_non_admin'      => [ 'label' => __( 'Hide admin bar for non-admins', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'checkbox' ],
            'header_scripts'           => [ 'label' => __( 'Custom scripts in <head>', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'textarea' ],
            'footer_scripts'           => [ 'label' => __( 'Custom scripts before </body>', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'textarea' ],
            'email_from_name'          => [ 'label' => __( 'Email sender name', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'text' ],
            'email_from_address'       => [ 'label' => __( 'Email sender address', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'email' ],
            'self_pingbacks'           => [ 'label' => __( 'Disable self-pingbacks', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'checkbox' ],
            'clean_head'               => [ 'label' => __( 'Clean <head> (RSD, WLW, shortlink)', 'wp10ms-tools' ), 'section' => 'wp10mstools_custom', 'type' => 'checkbox' ],
        ];
    }

    public function sanitize( $input ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return get_option( Plugin::OPTION_KEY, [] );
        }

        $out    = [];
        $fields = $this->fields();

        foreach ( $fields as $key => $field ) {
            if ( 'checkbox' === $field['type'] ) {
                $out[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
            } elseif ( 'number' === $field['type'] ) {
                $val = isset( $input[ $key ] ) ? (int) $input[ $key ] : 0;
                $min = isset( $field['min'] ) ? (int) $field['min'] : 0;
                $max = isset( $field['max'] ) ? (int) $field['max'] : 50;
                $out[ $key ] = max( $min, min( $max, $val ) );
            } elseif ( 'email' === $field['type'] ) {
                $out[ $key ] = isset( $input[ $key ] ) ? sanitize_email( $input[ $key ] ) : '';
            } elseif ( 'text' === $field['type'] ) {
                $out[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
            } elseif ( 'textarea' === $field['type'] ) {
                $raw = isset( $input[ $key ] ) ? (string) $input[ $key ] : '';
                // Allow unfiltered_html for admins (WP handles capability). Otherwise, kses.
                if ( current_user_can( 'unfiltered_html' ) ) {
                    $out[ $key ] = $raw;
                } else {
                    $out[ $key ] = wp_kses_post( $raw );
                }
            }
        }

        return $out;
    }

    public function field_callback( array $args ): void {
        $key   = $args['key'];
        $field = $args['field'];
        $opts  = $this->plugin->options();
        $val   = $opts[ $key ] ?? '';

        switch ( $field['type'] ) {
            case 'checkbox':
                printf(
                    '<label><input type="checkbox" name="%1$s[%2$s]" value="1" %3$s /> %4$s</label>',
                    esc_attr( Plugin::OPTION_KEY ),
                    esc_attr( $key ),
                    checked( ! empty( $val ), true, false ),
                    esc_html__( 'Enable', 'wp10ms-tools' )
                );
                break;
            case 'number':
                printf(
                    '<input type="number" name="%1$s[%2$s]" value="%3$s" min="%4$d" max="%5$d" class="small-text" />',
                    esc_attr( Plugin::OPTION_KEY ),
                    esc_attr( $key ),
                    esc_attr( (string) $val ),
                    isset( $field['min'] ) ? (int) $field['min'] : 0,
                    isset( $field['max'] ) ? (int) $field['max'] : 50
                );
                break;
            case 'email':
            case 'text':
                printf(
                    '<input type="%5$s" name="%1$s[%2$s]" value="%3$s" class="regular-text" />',
                    esc_attr( Plugin::OPTION_KEY ),
                    esc_attr( $key ),
                    esc_attr( (string) $val ),
                    esc_attr( $key ),
                    esc_attr( $field['type'] )
                );
                break;
            case 'textarea':
                printf(
                    '<textarea name="%1$s[%2$s]" rows="6" class="large-text code">%3$s</textarea><p class="description">%4$s</p>',
                    esc_attr( Plugin::OPTION_KEY ),
                    esc_attr( $key ),
                    esc_textarea( (string) $val ),
                    esc_html__( 'Accepts HTML/JS. Use responsibly.', 'wp10ms-tools' )
                );
                break;
        }
    }

    public function render(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $title = __( 'WP10MS Tools', 'wp10ms-tools' );
        include WP10MSTOOLS_DIR . 'includes/admin/views/settings-page.php';
    }
}