<?php
/**
 * Header menu template part.
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Header style
$header_style = get_theme_mod( 'kindling_header_style', 'minimal' );

# Menu Location
$menu_location = apply_filters( 'kindling_main_menu_location', 'main_menu' );

# Multisite global menu
$ms_global_menu = apply_filters( 'kindling_ms_global_menu', false );

# Display menu if defined
if ( has_nav_menu( $menu_location ) || $ms_global_menu ) : 

	# Get classes for the header menu
	$wrap_classes  = kindling_header_menu_classes( 'wrapper' );
	$inner_classes = kindling_header_menu_classes( 'inner' );

	# Get menu classes
	$menu_classes = array( 'main-menu' );
	$menu_classes[] = 'dropdown-menu sf-menu';

	// Turn menu classes into space seperated string
 	$menu_classes = implode( ' ', $menu_classes );
 
	# Menu arguments
	$menu_args = array(
		'theme_location' => $menu_location,
		'menu_class'     => $menu_classes,
		'container'      => false,
		'fallback_cb'    => false,
		'link_before'    => '<span>',
		'link_after'     => '</span>',
		'walker'         => new Kindling_Custom_Nav_Walker(),
	);

	# Check if custom menu
	if ( $menu = kindling_header_custom_menu() ) {
		$menu_args['menu']  = $menu;
	}

	do_action( 'kindling_before_nav' );	?>
		<div id="site-navigation-wrap" class="<?php echo $esc_attr( $wrap_classes ); ?>">
	<?php
	do_action( 'kindling_before_nav_inner' ); ?>

		<nav id="site-navigation" class="<?php echo esc_attr( $inner_classes ); ?>" itemscope itemtype="//schema.org/SiteNavigationElement">

			<?php
			# Display global multisite menu
			if ( is_multisite() && $ms_global_menu ) :
				
				switch_to_blog( 1 );  
				wp_nav_menu( $menu_args );
				restore_current_blog();

			# Display this site's menu
			else :

				wp_nav_menu( $menu_args );

			endif;

			# If is not top menu header style
			if ( 'top' != $header_style ) {

				# Header search
				if ( 'drop_down' == kindling_menu_search_style() ) {
					get_template_part( 'partials/header/search-dropdown' );
				} else if ( 'header_replace' == kindling_menu_search_style() ) {
					get_template_part( 'partials/header/search-replace' );
				} else if ( 'overlay' == kindling_menu_search_style() ) {
					get_template_part( 'partials/header/search-overlay' );
				}

			}

			# WooCommerce cart
			if ( 'drop_down' == kindling_menu_cart_style() ) {
				get_template_part( 'partials/cart/cart-dropdown' );
			}
			?>

		</nav><!-- #site-navigation -->

		<?php do_action( 'kindling_after_nav_inner' ); ?>

		</div><!-- #site-navigation-wrap -->

	<?php do_action( 'kindling_after_nav' ); ?>

<?php endif; ?>