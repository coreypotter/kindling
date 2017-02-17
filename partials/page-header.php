<?php
/**
 * The template for displaying the page header.
 *
 * @package Kindling Theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if page header is disabled
if ( ! kindling_has_page_header() ) {
	return;
}

// Classes
$classes = array( 'page-header' );

// Get header style
$style = kindling_page_header_style();

// Add classes for title style
if ( $style ) {
	$classes[$style .'-page-header'] = $style .'-page-header';
}

// Turn into space seperated list
$classes = implode( ' ', $classes ) ?>

<?php do_action( 'kindling_before_page_header' ); ?>

<header class="<?php echo esc_attr( $classes ); ?>">

	<?php do_action( 'kindling_before_page_header_inner' ); ?>

	<div class="container clr page-header-inner">

		<h1 class="page-header-title kindling-clr" itemprop="headline"><?php echo kindling_title(); ?></h1>

		<?php get_template_part( 'partials/page-header-subheading' ); ?>

		<?php if ( function_exists( 'kindling_breadcrumb_trail' ) ) {
			kindling_breadcrumb_trail();
		} ?>

	</div><!-- .page-header-inner -->

	<?php kindling_page_header_overlay(); ?>

	<?php do_action( 'kindling_after_page_header_inner' ); ?>

</header><!-- .page-header -->

<?php do_action( 'kindling_after_page_header' ); ?>