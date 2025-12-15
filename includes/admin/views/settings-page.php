<?php
/** 
 * @var string $title 
 * */

use WP10MSTools\Plugin;

?>
<div class="wrap wp10mstools-wrap">
    <h1><?php echo esc_html( $title ); ?></h1>
    <p class="description"><?php esc_html_e( 'Toggle simple, safe tweaks for performance, security, and customization.', 'wp10ms-tools' ); ?></p>

    <form method="post" action="options.php">
        <?php settings_fields( 'wp10mstools_settings' ); ?>
        <?php do_settings_sections( 'wp10mstools' ); ?>
        <?php submit_button( __( 'Save Changes', 'wp10ms-tools' ) ); ?>
    </form>
</div>