<?php
/**
 * Site header search header replace
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="searchform-header-replace" class="header-searchform-wrap clr">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-searchform">
		<input type="search" name="s" autocomplete="off" value="" placeholder="<?php echo esc_html__( 'Type then hit enter to search...', 'kindling' ); ?>" />
	</form>
	<span id="searchform-header-replace-close" class="icon-close"></span>
</div><!-- #searchform-header-replace -->