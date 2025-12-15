<?php
/**
 * WP10MS Tools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WP10MS Tools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Plugin Name. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete plugin options.
delete_option( 'wp10mstools_options' );

// Multisite cleanup.
if ( is_multisite() ) {
    $sites = get_sites( array( 'fields' => 'ids' ) );
    foreach ( $sites as $blog_id ) {
        switch_to_blog( $blog_id );
        delete_option( 'wp10mstools_options' );
        restore_current_blog();
    }
}
