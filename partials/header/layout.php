<?php
/**
 * Main Header Layout
 *
 * @package Kindling Theme
 */

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Header style
$header_style = kindling_header_style();

# Header height, used for local scrolling
$header_height = get_theme_mod( 'kindling_header_height', '74' );

if ( class_exists( 'Kindling_Sticky_Header' ) ) {

	$sticky_style = get_theme_mod( 'osh_sticky_header_style', 'shrink' );

	if ( 'shrink' == $sticky_style ) {
		$header_height = get_theme_mod( 'osh_shrink_header_height', '54' );
	} else if ( 'fixed' == $sticky_style ) {
		$header_height = get_theme_mod( 'osh_fixed_header_height', '54' );
	}

}

do_action( 'kindling_before_header' );

# If transparent header style
if ( 'transparent' == $header_style ) { ?>
	<div id="transparent-header-wrap" class="clr">
<?php
} ?>

<header id="site-header" class="<?php echo kindling_header_classes(); ?>" itemscope="itemscope" itemtype="http:#schema.org/WPHeader" data-height="<?php echo esc_attr( $header_height ); ?>">

	<?php
	# If top header style
	if ( 'top' == $header_style ) {
		get_template_part( 'partials/header/style/top-header' );
	}

	# If full screen header style
	else if ( 'full_screen' == $header_style ) {
		get_template_part( 'partials/header/style/full-screen-header' );
	}

	# If custom header style
	else if ( 'custom' == $header_style ) {
		get_template_part( 'partials/header/style/custom-header' );
	}

	# Default header style
	else { ?>

		<?php do_action( 'kindling_before_header_inner' ); ?>

		<div id="site-header-inner" class="container clr">

			<?php get_template_part( 'partials/header/logo' ); ?>

			<?php if ( true == get_theme_mod( 'kindling_menu_social', false ) ) {
				get_template_part( 'partials/header/social' );
			} ?>

			<?php get_template_part( 'partials/header/nav' ); ?>

			<?php get_template_part( 'partials/header/mobile-icon' ); ?>

		</div><!-- #site-header-inner -->

		<?php do_action( 'kindling_after_header_inner' ); ?>

	<?php
	} ?>

</header><!-- #header -->

<?php
# If transparent header style
if ( 'transparent' == $header_style ) { ?>
	</div>
<?php
}

do_action( 'kindling_after_header' ); ?>