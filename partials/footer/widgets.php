<?php
/**
 * Footer widgets
 *
 * @package Kindling Theme
 */

namespace Elementor;

# Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Get page
$get_page 	= kindling_footer_page_id();

# Get page ID
$get_id 	= get_theme_mod( 'kindling_footer_widgets_page_id' );

# Check if page is Elementor page
$elementor 	= get_post_meta( $get_id, '_elementor_edit_mode', true );

# Get footer widgets columns
#$columns    = get_theme_mod( 'kindling_footer_widgets_columns', '4' );
$columns = 1;
$grid_class = kindling_grid_class( $columns );

# Classes
$wrap_classes = array( 'clr' );
if ( '1' == $columns ) {
	$wrap_classes[] = 'single-col-footer';
}
$wrap_classes = implode( ' ', $wrap_classes );

do_action( 'kindling_before_footer_widgets' );
?>

<div id="footer-widgets" class="kindling-row <?php echo $wrap_classes; ?>">
	<?php do_action( 'kindling_before_footer_widgets_inner' ); ?>
	<div class="container">
        <?php
		    # If Elementor
		    if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {
				echo Plugin::instance()->frontend->get_builder_content_for_display( $get_id );
	    	}

	    	# If Beaver Builder
		    else if ( class_exists( 'FLBuilder' ) ) {
				echo do_shortcode( '[fl_builder_insert_layout id="' . $get_id . '"]' );
	    	}

	    	# Else
	    	else {
	        	# Display page content
				echo do_shortcode( $get_page );
	        }
?>
	</div><!-- .container -->
	<?php do_action( 'kindling_after_footer_widgets_inner' ); ?>
	</div><!-- #footer-widgets -->

<? do_action( 'kindling_after_footer_widgets' ); ?>