<?php
/**
 * Mobile search template.
 *
 * @package Kindling Theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="mobile-menu-search" class="clr">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-searchform">
		<input type="search" name="s" autocomplete="off" placeholder="<?php echo esc_attr( apply_filters( 'kindling_mobile_searchform_placeholder', __( 'Search', 'kindling' ) ) ); ?>" />
		<button type="submit" class="searchform-submit">
			<span class="icon icon-magnifier"></span>
		</button>
	</form>
</div><!-- .mobile-menu-search -->