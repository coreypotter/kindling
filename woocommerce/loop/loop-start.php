<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ( kindling_is_woo_shop() || kindling_is_woo_tax() )
	&& get_theme_mod( 'kindling_woo_grid_list', true )
	&& 'list' == get_theme_mod( 'kindling_woo_catalog_view', 'grid' ) ) {
	$class = ' list';
} else {
	$class = ' grid';
} ?>

<ul class="products kindling-row clr<?php echo esc_attr( $class ); ?>">