<?php
/**
 * Topbar menu displays inside the topbar "content" area
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Display menu
wp_nav_menu( array(
	'theme_location' => 'topbar_menu',
	'fallback_cb'    => false,
	'container'      => false,
	'menu_class'     => 'top-bar-menu dropdown-menu sf-menu',
	'walker'         => new Kindling_Custom_Nav_Walker(),
) ); ?>