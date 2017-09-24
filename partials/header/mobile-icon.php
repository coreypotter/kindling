<?php
/**
 * Mobile Menu icon
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Global woo
global $woocommerce;

# Menu Location
$menu_location = apply_filters( 'kindling_main_menu_location', 'main_menu' );

# Multisite global menu
$ms_global_menu = apply_filters( 'kindling_ms_global_menu', false );

# Display if menu is defined
if ( has_nav_menu( $menu_location ) || $ms_global_menu ) :

	# Get menu icon
	$icon_class = get_theme_mod( 'kindling_mobile_menu_icon', 'bars' );
	$icon = '<i class="fa fa-'.$icon_class.'"></i>';

	# Get menu text
	$text = get_theme_mod( 'kindling_mobile_menu_text', 'Menu' );

	if ( KINDLING_WOOCOMMERCE_ACTIVE ) {

		# Cart icon
		$cart_icon = '<i class="icon-handbag"></i>';

	} ?>

	<div id="kindling-mobile-menu-icon" class="clr">
		
		<?php do_action( 'kindling_before_mobile_icon' ); ?>
		<?php
		// Cart icon
		if ( KINDLING_WOOCOMMERCE_ACTIVE
			&& 'disabled' != get_theme_mod( 'kindling_woo_menu_icon_display', 'icon_count' ) ) { ?>
			<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="mobile-wcmenucart"><?php echo wp_kses_post( $cart_icon ); ?></a>
		<?php } ?>

		<a href="#" class="mobile-menu"><?php echo wp_kses_post( $icon ); ?><span class="kindling-text"><?php echo esc_html( $text ); ?></span></a>

		<?php do_action( 'kindling_after_mobile_icon' ); ?>

	</div><!-- #kindling-mobile-menu-navbar -->

<?php endif; ?>