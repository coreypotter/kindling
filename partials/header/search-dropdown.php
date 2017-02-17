<?php
/**
 * Site header search dropdown HTML
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="searchform-dropdown" class="header-searchform-wrap clr">
	<?php get_search_form( true ); ?>
</div><!-- #searchform-dropdown -->