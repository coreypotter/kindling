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

do_action( 'kindling_before_header' ); ?>

<header id="site-header" class="<?php echo esc_attr( kindling_header_classes() ); ?>" itemscope itemtype="//schema.org/WPHeader" data-height="<?php echo esc_attr( $header_height ); ?>">

	<?php
	# If top header style
	if ( 'top' == $header_style ) {
		get_template_part( 'partials/header/style/top-header' );
	}

	# Default header style
	else { ?>

		<?php do_action( 'kindling_before_header_inner' ); ?>

		<div id="site-header-inner" class="container clr">

			<?php get_template_part( 'partials/header/logo' ); ?>

			<?php get_template_part( 'partials/header/nav' ); ?>

			<?php get_template_part( 'partials/header/mobile-icon' ); ?>

		</div><!-- #site-header-inner -->

		<?php do_action( 'kindling_after_header_inner' ); ?>

	<?php
	} ?>

</header><!-- #header -->

<?php do_action( 'kindling_after_header' ); ?>